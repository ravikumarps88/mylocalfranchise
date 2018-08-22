var gulp = require('gulp');
var sass = require('gulp-sass');
var postcss = require('gulp-postcss');
var lost = require('lost');
var autoprefixer = require('autoprefixer');
var cssnano = require('cssnano');
var sourcemaps = require('gulp-sourcemaps');
var concat = require('gulp-concat');
var rename = require('gulp-rename');  
var uglify = require('gulp-uglify'); 

gulp.task('styles', function() {
	var processors = [
		lost(),
		autoprefixer({browsers: ['last 2 version']}),
		cssnano({
			discardComments: { removeAll: true },
			core: true
		})
	];

	var sassOptions = {
		errLogToConsole: true
	};

	return gulp.src('../scss/style.scss')
		.pipe(sourcemaps.init())
		.pipe(sass(sassOptions).on('error', sass.logError))
		.pipe(postcss(processors))
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest('../css/'));
});


gulp.task('scripts', function() {
	return gulp.src(['../js/bootstrap/util.js', '../js/bootstrap/alert.js', '../js/bootstrap/collapse.js', '../js/bootstrap/modal.js', '../js/bootstrap/tab.js',])
		.pipe(concat('main.js'))
		.pipe(gulp.dest('../js/'))
		.pipe(rename('main.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('../js/'));
});

gulp.task('watch:styles', function() {
	gulp.watch('../**/*.scss', ['styles']);
});