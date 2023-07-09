var gulp = require('gulp');
var sass = require('gulp-sass');

gulp.task('sass', function() {
    gulp.src('./assets/sass/listing-manager-front.scss')
        .pipe(sass())
        .pipe(gulp.dest('./assets/css')); 
});

gulp.task('watch', function() {
    gulp.watch('./assets/sass/**', ['sass']);
});
