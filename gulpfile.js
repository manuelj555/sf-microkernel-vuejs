var gulp = require('gulp');
var autoprefixer = require('gulp-autoprefixer');
var scss = require('gulp-sass');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var uglifycss = require('gulp-uglifycss');
//var rewriteCSS = require('gulp-rewrite-css');
var babel = require('gulp-babel');
var gutil = require("gulp-util");
var replace = require('gulp-replace');
// Dependencias para compilar VueJS files
var browserify = require('browserify')
var vueify = require('vueify')
var babelify = require('babelify');
var source = require('vinyl-source-stream');
var buffer = require('vinyl-buffer');

var resourcesPath = './app/Resources/assets/';
var assetsPath = './app/Resources/public/';

gulp.task('js', function () {
    return gulp.src([
        'app/Resources/assets/vendors/jquery/dist/jquery.min.js',
        'app/Resources/assets/vendors/bootstrap-sass/assets/javascripts/bootstrap.min.js',
        'app/Resources/assets/vendors/medium-editor/dist/js/medium-editor.min.js',
        'app/Resources/assets/vendors/lodash/dist/lodash.min.js',
        'app/Resources/assets/vendors/pnotify/dist/pnotify.js',
        'app/Resources/public/js/**/*.js',
    ])
    .pipe(babel())
    .pipe(uglify())
    .on("error", function(err){
        gutil.log(err)
        this.emit('end');
    })
    .pipe(concat('app.js'))
    .pipe(gulp.dest('public/compiled/js'))
});

gulp.task('css', function () {
    var dest = 'public/compiled/css';

    return gulp.src([
        'app/Resources/public/css/**/*.scss',
        'app/Resources/assets/vendors/medium-editor/dist/css/medium-editor.min.css',
        'app/Resources/assets/vendors/medium-editor/dist/css/themes/bootstrap.min.css',
        'app/Resources/assets/vendors/pnotify/dist/pnotify.css',
        'app/Resources/assets/vendors/font-awesome/css/font-awesome.min.css',
    ])
        .pipe(scss()).on('error', scss.logError)
        //.pipe(rewriteCSS({destination:dest}))
        .pipe(replace('../fonts/', '../../fonts/'))
        .pipe(concat('frontend.css'))
        .pipe(uglifycss())
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(gulp.dest(dest));
});

gulp.task('assets:bs-fonts', function () {
    return gulp.src([
        'app/Resources/assets/vendors/bootstrap-sass/assets/fonts/**/*',
    ])
      .pipe(gulp.dest('public/fonts/'));
});

gulp.task('assets:fa-fonts', function () {
    return gulp.src([
        'app/Resources/assets/vendors/font-awesome/fonts/**/*',
    ])
      .pipe(gulp.dest('public/fonts/'));
});

// Cuando ocurra algun cambio en .scss se ejecutara la tarea sass definida.
gulp.task('css:watch', ['css'], function() {
    gulp.watch([
        'app/Resources/public/css/**/*.scss',
        'app/Resources/public/css/**/*.css',
    ], ['css']);
});

gulp.task('vueify', function () {
  return browserify(resourcesPath + 'vue/app.js')
  .transform(babelify, { presets: ['es2015'], plugins: ["transform-runtime"] })
  .transform(vueify)
  .bundle()
  .on("error", function(err){
    gutil.log(err)
    this.emit('end');
  })
  .pipe(source("vue_app.js"))
  .pipe(buffer())
  .pipe(gutil.env.env === 'prod' ? uglify() : gutil.noop())
  .pipe(gulp.dest("./public/compiled/js/"));
});

gulp.task('vueify:watch', ['vueify'], function () {
  return gulp.watch(["vue/**/*.js", "vue/**/*.vue", "js/**/*.js"], {cwd: resourcesPath}, ["vueify"])
    .on("change", function(event){
        gutil.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
    });
});

gulp.task('assets', ['assets:bs-fonts', 'assets:bs-fonts']);
gulp.task('default', ['css', 'js', 'vueify', 'assets']);