var gulp = require('gulp');
var sass = require('gulp-sass');

// Compile sass into CSS & auto-inject into browsers
gulp.task('sass', function() {
  return gulp.src("scss/styles.scss")
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest("public/css"))
    .pipe(browserSync.stream());
});

gulp.task('run', ['sass']);