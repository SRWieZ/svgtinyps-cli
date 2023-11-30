# Removing old build files
rm -rf build/bin/
#rm -rf build/buildroot/
#rm -rf build/downloads/
#rm -rf build/source/
#rm -rf build/static-php-cli/

# Directories
mkdir -p build/bin/

# Build phar file using box and bos.json
composer box compile

# Fetch or update static-php-cli
if [ -d "build/static-php-cli" ]; then
  cd build/static-php-cli/
#  git reset --hard HEAD
  git pull
else
  cd build/
  git clone https://github.com/crazywhalecc/static-php-cli.git
  cd static-php-cli/
fi

# Install dependencies
composer install --no-interaction
chmod +x bin/spc

# Back to main directory
cd ../

# Build PHP Micro with only the extensions we need
./static-php-cli/bin/spc doctor
./static-php-cli/bin/spc download --with-php=8.2 --for-extensions=dom,phar
./static-php-cli/bin/spc build dom,phar --build-micro

# Build binary
./static-php-cli/bin/spc micro:combine bin/svgtinyps.phar --output=bin/svgtinyps
chmod 0755 bin/svgtinyps

# Check if it's working !
cd ../
./build/bin/svgtinyps help
