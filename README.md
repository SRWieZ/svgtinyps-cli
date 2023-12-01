# svgtinyps

![GitHub release (with filter)](https://img.shields.io/github/v/release/SRWieZ/svgtinyps-cli)
![Packagist PHP Version](https://img.shields.io/packagist/dependency-v/SRWieZ/svgtinyps-cli/php)
![Packagist License (custom server)](https://img.shields.io/packagist/l/SRWieZ/svgtinyps-cli)
![GitHub Workflow Status (with event)](https://img.shields.io/github/actions/workflow/status/SRWieZ/svgtinyps-cli/test.yml)


CLI Tool for SVG Tiny P/S (Portable and Secure) conversion and BIMI compliance.

[Read more from bimi group](https://bimigroup.org/creating-bimi-svg-logo-files/)
and [the RFC](https://datatracker.ietf.org/doc/id/draft-svg-tiny-ps-abrotman-00.txt)

🧪 If you just want to convert your SVG in a nice ui, you can use the
[online version of the converter!](https://checkbimi.com/convertsvg)

You can also checkout the [PHP package](https://github.com/SRWieZ/php-svg-ps-converter) that this project is based on.

## Installation

[//]: # (Download the latest release from [Github releases]&#40;https://github.com/SRWieZ/svgtinyps-cli/releases&#41;)

Via [Composer](https://getcomposer.org/) global install command
```bash
composer global install srwiez/svgtinyps-cli
```

[//]: # (Coming soon to [Homebrew]&#40;https://brew.sh/&#41;)

[//]: # (Via [Homebrew]&#40;https://brew.sh/&#41; &#40;macOS & Linux&#41;)

[//]: # (```bash)

[//]: # (brew tap srwiez/homebrew-tap)

[//]: # (brew install svgtinyps)

[//]: # (```)

## Usage

Convert an SVG file to SVG (P/S)

```bash
svgtinyps convert input.svg output.svg
```

Identify issues in an SVG file

```bash
svgtinyps issues input.svg
```

[//]: # (Minify an SVG file)

[//]: # ()
[//]: # (```bash)

[//]: # (svgtinyps minify input.svg)

[//]: # (```)


## Testing
This project use [Pest](https://pestphp.com/) for testing.
```bash
composer test
```

## Build from sources
This project use [box](https://github.com/box-project/box), [php-static-cli](https://github.com/crazywhalecc/static-php-cli) and [php-micro](https://github.com/dixyes/phpmicro).
A build script has been created to build the project. (tested only on macOS x86_64)
```bash
composer build
```

You can also build it from Github Workflow, or locally using [act](https://github.com/nektos/act)
```bash
act -j build-macos-binary -P macos-latest=-self-hosted

#upcomming soon
act -j build-linux-binary
act -j build-windows-binary
```
## Roadmap
Pull requests are welcome! Here are some ideas to get you started:
- Option to set <title>
- Use Symfony Console for better ui
- Build binaries for Windows, Linux and MacOS
- Publish on Homebrew 
- Automate everything with Github Actions


## Credits

**svgtinyps** was created by Eser DENIZ.

Inspired by the official scripts
of [authindicators/svg-ps-converters](https://github.com/authindicators/svg-ps-converters)

Thanks to [gilbarbara/logos](https://github.com/gilbarbara/logos) for the logos used in the tests.

## License

**svgtinyps** PHP is licensed under the MIT License. See LICENSE for more information.