var gulp = require('gulp');
var autoprefixer = require('gulp-autoprefixer');
var scss = require('gulp-sass');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var uglifycss = require('gulp-uglifycss');
var rewriteCSS = require('gulp-rewrite-css');
var gutil = require("gulp-util");
// Dependencias para compilar VueJS files
var browserify = require('browserify')
var vueify = require('vueify')
var babelify = require('babelify');
var source = require('vinyl-source-stream');
var buffer = require('vinyl-buffer');

var assetsPath = './app/Resources/public/';

gulp.task('js', function () {
    return gulp.src([
        'app/Resources/public/vendors/jquery/dist/jquery.min.js',
        'app/Resources/public/vendors/bootstrap-sass/assets/javascripts/bootstrap.min.js',
        'app/Resources/public/vendors/medium-editor/dist/js/medium-editor.js',
        'app/Resources/public/vendors/lodash/dist/lodash.min.js',
        'app/Resources/public/js/**/*.js',
    ])
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
        'app/Resources/public/vendors/medium-editor/dist/css/medium-editor.min.css',
        'app/Resources/public/vendors/medium-editor/dist/css/themes/bootstrap.min.css',
    ])
        .pipe(scss()).on('error', scss.logError)
        .pipe(rewriteCSS({destination:dest}))
        .pipe(concat('frontend.css'))
        .pipe(uglifycss())
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(gulp.dest(dest));
});

// Cuando ocurra algun cambio en .scss se ejecutara la tarea sass definida.
gulp.task('css:watch', ['css'], function() {
    gulp.watch([
        'app/Resources/public/css/*.scss',
        'app/Resources/public/css/**/*.scss',
    ], ['css']);
});

gulp.task('vueify', function () {
    process.env.NODE_ENV = 'production'
  return browserify(assetsPath + 'vue/app.js')
  .transform(babelify, { presets: ['es2015'], plugins: ["transform-runtime"] })
  .transform(vueify)
  .bundle()
  .on("error", function(err){
    gutil.log(err)
    this.emit('end');
  })
  .pipe(source("vue_app.js"))
  .pipe(buffer())
  .pipe(uglify())
  .pipe(gulp.dest("./public/compiled/js/"));
});

gulp.task('vueify:watch', ['vueify'], function () {
  return gulp.watch(["vue/**/*.js", "vue/**/*.vue"], {cwd: assetsPath}, ["vueify"])
    .on("change", function(event){
        gutil.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
    });
});

gulp.task('default', ['css', 'js', 'vueify']);