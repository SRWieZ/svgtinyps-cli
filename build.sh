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

#TODO : build with static php having pretty much only ext-dom to reduce size of binary

cat ./tmp/micro.sfx ./build/svgtinyps.phar > ./build/svgtinyps
chmod 0755 ./build/svgtinyps