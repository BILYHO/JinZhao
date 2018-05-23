# ReactNative
  1. 先安装Homebrew
            
    /usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"
     
  2. 使用Homebrew来安装Node.js.
    
    brew install node //可以手动下载node
    
  3. Yarn、React Native的命令行工具（react-native-cli）
    
    Yarn是Facebook提供的替代npm的工具，可以加速node模块的下载。
    React Native的命令行工具用于执行创建、初始化、更新项目、运行打包服务（packager）等任务。
    
    npm install -g yarn react-native-cli
    
  4. 安装完yarn后同理也要设置镜像源：
    
    安装完yarn后同理也要设置镜像源： 
   
    yarn config set registry https://registry.npm.taobao.org --global
    yarn config set disturl https://npm.taobao.org/dist --global
    
    如果你看到EACCES: permission denied这样的权限报错，那么请参照上文的homebrew译注，修复/usr/local目录的所有权：
    
    sudo chown -R `whoami` /usr/local
    
    