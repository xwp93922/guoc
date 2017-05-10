主题规则
1、页面模板文件放在views目录中
2、css/js/images等资源文件存放在dist目录中
3、在AppAsset.php修改需要引入的相关资源文件，这些资源文件会自动发布到web/asserts目录下
4、修改views/layouts/main.php文件中AppAsset的命名空间，修改为当前主题的命名空间