# removing old build files
rm -rf ./build/
#rm -rf ./tmp/

# Build phar file using box and bos.json
composer pint
composer box compile

#mkdir -p ./tmp
#cd tmp
#curl -O https://dl.static-php.dev/static-php-cli/common/php-8.2.12-micro-macos-x86_64.tar.gz
#tar -xvf php-8.2.12-micro-macos-x86_64.tar.gz
#cd ..

#TODO : build static php first to have pretty much only ext-dom and reduce size of binary
#TODO : Make it CI/CD ready

mkdir -p ./build/macos-x86_64
cat ./tmp/micro.sfx ./build/svgtinyps.phar > ./build/macos-x86_64/svgtinyps
chmod 0755 ./build/macos-x86_64/svgtinyps