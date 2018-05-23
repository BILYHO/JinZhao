/**
 * Created by BILYHO on 17/8/14.
 */

    /****************目录常量配置*********************/
    var src      = "./src/",							//源文件根目录
        srcHtml     = src + "html/",					//源HTML文件目录
        srcCss      = src + "css/",					    //源CSS文件目录
        srcJs       = src + "js/",						//源JS文件目录
        srcScss     = src + "scss/",					//源Scss文件目录
        srcImage    = src + "images/",					//源图片文件目录
        srcFont     = src + "font/",					//源字体文件目录
        srcMedia    = src + "media/",				    //源媒体文件目录

        target      = "./dist/",						//目标文件根目录
        targetHtml  = target + "html/",					//目标HTML文件目录
        targetCss   = target + "css/",					//目标CSS文件目录
        targetJs    = target + "js/",					//目标JS文件目录
        targetImage = target + "images/",				//目标JS文件目录
        targetFont  = target + "font/",					//目标字体文件目录
        targetMedia = target + "media/",				//目标媒体文件目录

        revDir = "./rev/";								//转换文件对应关系的json存放目录

    //引入gulp
    let gulp            =   require('gulp');
    // let del             =   require('del');                     //清空文件
    let sass            =   require('gulp-sass');               //scss 转 css
    let autoprefixer 	= 	require('gulp-autoprefixer');		//自动前缀
    let uglify 			=	require("gulp-uglify");				//JS压缩
    let minicss             =   require('gulp-minify-css');         //css压缩
    let rev 			=	require('gulp-rev');				//添加md5后缀
    let browserSync 	= 	require('browser-sync').create();   //创建一个browserSync实例

    /**
        子任务：清空文件夹
        npm install --save-dev gulp del
     */
    // gulp.task('clean',function(cb){
    //     del([
    //         // 这里我们使用一个通配模式来匹配 `dist` 文件夹中的所有东西
    //         'dist/**/*',
    //         'src/**/*',
    //         'rev/**/*',
    //     ], cb);
    // });

    /**
        子任务：使用Browsersync  同步刷新

        npm install browser-sync --save-dev
     */
    var reload = browserSync.reload;
    gulp.task('browserSync', function() {
        browserSync.init({
            port: 8080,
            server: {
                baseDir: src
            }
        });
    });

    /**
      子任务：转变scss到css
      npm install --save-dev gulp-sass
     */
    gulp.task('scss', function () {
        gulp.src(srcScss+'**/*.scss')
            .pipe(sass())
            //自动添加前缀
            .pipe(autoprefixer({
                browsers: ['last 2 versions', 'Android >= 4.0','iOS 7','last 3 Safari versions'],
                cascade: false, 	//是否美化属性值 默认：true 像这样：
                //-webkit-transform: rotate(45deg);
                //        transform: rotate(45deg);
                remove:false 		//是否去掉不必要的前缀 默认：true
            }))
            .pipe(gulp.dest(srcCss));
    });

    /**
         子任务：js压缩
         npm install --save-dev gulp-uglify
     */

    //不能压缩es6 的js 需要 压缩es6 要用webpack
    gulp.task('js', function () {
        return gulp.src(srcJs+'**/*.js')
            .pipe(uglify())                 //进行压缩
            // .pipe(rev())
            .pipe(gulp.dest(targetJs))
            .pipe(rev.manifest())
            .pipe(gulp.dest(revDir+'js'));
        // .pipe(gulp.dest(revDir+'js'));
    });

    /**
     子任务：css压缩
     npm install --save-dev gulp-minify-css
     */
    gulp.task("css",function(){
        gulp.src(srcCss+"**/*.css")
            .pipe(minicss())			//进行压缩
            // .pipe(rev())
            .pipe(gulp.dest(targetCss))
            .pipe( rev.manifest() )
            .pipe( gulp.dest( revDir+'css' ) );
    });




    gulp.task("dev",["browserSync"],function(){

        //监听任何文件变化,实时刷新
        gulp.watch(srcHtml+"**/**/*.html").on("change",reload);
        gulp.watch(srcCss+"**/*.css").on("change",reload);
        gulp.watch(srcJs+"**/*.js").on("change",reload);
        gulp.watch(srcScss+'**/*.scss',['scss']);
        gulp.watch(srcScss+'**/*.scss',['css']);
        gulp.watch(srcJs+'**/*.js',['js']);

    });




    /**
        总任务：一键用于开发环境
     */
    gulp.task('default', ['dev']);
