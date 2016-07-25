var gulp = require('gulp');
var autoprefixer = require('gulp-autoprefixer');
var scss = require('gulp-sass');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var uglifycss = require('gulp-uglifycss');
var rewriteCSS = require('gulp-rewrite-css');

gulp.task('js', function () {
    return gulp.src([
        'app/Resources/public/vendors/jquery/dist/jquery.min.js',
        'app/Resources/public/vendors/bootstrap-sass/assets/javascripts/bootstrap.min.js',
        'app/Resources/public/js/**/*.js',
    ])
    .pipe(uglify())
    .pipe(concat('app.js'))
    .pipe(gulp.dest('public/compiled/js'));
});

gulp.task('css', function () {
    var dest = 'public/compiled/css';

    return gulp.src([
        'app/Resources/public/css/*.scss',
        'app/Resources/public/css/**/*.scss',
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
gulp.task('css:watch', function() {
    gulp.watch([
        'app/Resources/public/css/*.scss',
        'app/Resources/public/css/**/*.scss',
    ], ['css']);
})

gulp.task('default', ['css', 'js']);