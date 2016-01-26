// Include gulp
var gulp = require('gulp');

// Include Our Plugins
//var jshint = require('gulp-jshint');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var minifycss = require('gulp-cssnano');
var rename = require('gulp-rename');

// Lint Task
gulp.task('lint', function() {
	return gulp.src('js/*.js')
		.pipe(jshint())
		.pipe(jshint.reporter('default'));
});

// Compile Our sass
gulp.task('sass', function() {
	return gulp.src('scss/*.scss')
		.pipe(sass())
		.pipe(gulp.dest('css'));
});

// Concatenate & Minify JS
gulp.task('scripts', function() {
	return gulp.src('js/*.js')
		.pipe(concat('scripts.js'))
		.pipe(gulp.dest('dist/js'))
		.pipe(rename('scripts.min.js'))
		.pipe(uglify())
		.pipe(gulp.dest('dist/js'));
});

// Concatenate & Minify css
gulp.task('styles', function() {
	return gulp.src('css/*.css')
		.pipe(concat('styles.css'))
		.pipe(gulp.dest('dist/css'))
		.pipe(rename('styles.min.css'))
		.pipe(minifycss())
		.pipe(gulp.dest('dist/css'))
});

// Watch Files For Changes
gulp.task('watch', function() {
	//gulp.watch('js/*.js', ['lint', 'scripts']);
	gulp.watch('scss/*.scss', ['sass', 'styles']);
	//gulp.watch('less/*.less', ['less', 'styles']);
    //gulp.watch('dist/**/*', ['copydist']);
});

// Default Task
gulp.task('default', [ 'sass', 'styles', 'watch']);
