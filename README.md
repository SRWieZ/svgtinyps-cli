# svgtinyps

![GitHub release (with filter)](https://badgen.net/github/release/SRWieZ/svgtinyps-cli)
![Packagist PHP Version](https://badgen.net/packagist/php/SRWieZ/svgtinyps-cli)
![Packagist License (custom server)](https://badgen.net/packagist/license/SRWieZ/svgtinyps-cli)


CLI Tool for SVG Tiny P/S (Portable and Secure) conversion and BIMI compliance.

[Read more from bimi group](https://bimigroup.org/creating-bimi-svg-logo-files/)
and [the RFC](https://datatracker.ietf.org/doc/id/draft-svg-tiny-ps-abrotman-00.txt)

🧪 If you just want to convert your SVG in a nice UI, you can use the
[online version of the converter!](https://checkbimi.com/convertsvg)

You can also checkout the [PHP package](https://github.com/SRWieZ/php-svg-ps-converter) that this project is based on.

## 🚀 Installation

[//]: # (Download the latest release from [Github releases]&#40;https://github.com/SRWieZ/svgtinyps-cli/releases&#41;)

Via [Composer](https://getcomposer.org/) global install command
```bash
composer global install srwiez/svgtinyps-cli
```

By [downloading binaries](https://github.com/SRWieZ/svgtinyps-cli/releases/latest) on the latest release, currently only these binaries are compiled on the CI:
- macOS x86_64
- macOS arm64
- linux x86_64
- linux arm64
- windows x64

[//]: # (Coming soon to [Homebrew]&#40;https://brew.sh/&#41;)

[//]: # (Via [Homebrew]&#40;https://brew.sh/&#41; &#40;macOS & Linux&#41;)

[//]: # (```bash)

[//]: # (brew tap srwiez/homebrew-tap)

[//]: # (brew install svgtinyps)

[//]: # (```)

## 📚 Usage

Identify issues in an SVG file
```bash
svgtinyps issues input.svg
```

Convert an SVG file to SVG P/S (Portabler and Secure) format
```bash
svgtinyps convert input.svg output.svg
```

If in the identified issues, you missing th title tag, you can set its value with the `--title` option
```bash
svgtinyps convert input.svg output.svg --title="My awesome company"
```

Minify an SVG
```bash
svgtinyps minify input.svg output.svg
```


## 🚦 Testing
This project use [Pest](https://pestphp.com/) for testing.
```bash
composer test
```

## 👥 Contribute
This project follows PSR coding style. You can use `composer pint` to apply.

All tests are executed with pest. Use `composer pest`

It's recommended to execute `composer qa` before commiting (alias for executing Pint and Pest)

## 🔧 Build from sources
This project use [box](https://github.com/box-project/box), [php-static-cli](https://github.com/crazywhalecc/static-php-cli) and [php-micro](https://github.com/dixyes/phpmicro).
A build script has been created to build the project. (tested only on macOS x86_64)

```bash
composer build
```
Then you can build the binary that you can retrieve in `build/bin/`

[//]: # (You can also build it from Github Workflow, or locally on MacOS using [act]&#40;https://github.com/nektos/act&#41;)

[//]: # (```bash)

[//]: # (act -j build-macos-binary -P macos-latest=-self-hosted)

[//]: # (act -j build-linux-binary)

[//]: # (act -j build-linux-arm-binary)

[//]: # (```)
## 📋 Roadmap
Pull requests are welcome! Here are some ideas to get you started:
- Use Symfony Console for better ui
- Publish on Homebrew 

## 👥 Credits

**svgtinyps** was created by Eser DENIZ.

Inspired by the official scripts
of [authindicators/svg-ps-converters](https://github.com/authindicators/svg-ps-converters)

Thanks to [gilbarbara/logos](https://github.com/gilbarbara/logos) for the logos used in the tests.

## 📝 License

**svgtinyps** PHP is licensed under the MIT License. See LICENSE for more information.