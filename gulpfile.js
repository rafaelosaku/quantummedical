var gulp = require("gulp");
var sass = require("gulp-sass");
var notify = require("gulp-notify");


/**
A TASK Thor compila o arquivo SASS e gera um arquivo CSS minificado
*/
gulp.task('thor', function(){
	return gulp.src('./source/sass/*.scss')
		//.pipe(sass())
		/*A linha abaixo gera o arquivo minificado*/
		.pipe(sass({outputStyle: 'compressed'}))
		.on('error', notify.onError({title: 'Erro ao compilar', message: '<%=error.message %>'}))
		.pipe(gulp.dest('./themes/quantummedical/css'))
});

/**
   Move arquivos de dependência JS
*/
gulp.task('build-js', function(){
	return gulp.src([
		'./source/components/jquery/dist/jquery.js',
		'./source/components/jquery-mobile/jquery.mobile.custom.js',
		'./source/components/owl-carousel/owl.carousel.min.js'
		])
	.pipe(gulp.dest('./themes/quantummedical/js'))
});

/**
   Move arquivos de fontes do Font awsome
*/
gulp.task('move-fonts', function(){
	return gulp.src('./source/components/components-font-awesome/fonts/**')
	.pipe(gulp.dest('./themes/quantummedical/fonts'));
});

/**
   Move arquivos de manipulação do JQuery
*/
gulp.task('aquaman', function(){
	return gulp.src('./source/js/*.js')
	.pipe(gulp.dest('./themes/quantummedical/js/'));
});

gulp.task('demolidor', function(){
	gulp.watch('./source/sass/**/*.scss', ['thor']);
	gulp.watch('./source/js/**/*.js', ['aquaman']);
});

//Executa uma sequencia de tarefas default
gulp.task('default', ['build-js', 'thor', 'aquaman', 'demolidor', 'move-fonts']);