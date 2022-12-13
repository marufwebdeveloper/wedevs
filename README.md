About Plugins
About Plugins

Features
Installation
There are two ways by which you can install the scripts.

Clone the git repo to your local machine and then add the path to the repo to your PATH variable (or)
Execute the following commands in your terminal
cd /tmp
git clone https://github.com/marufwebdeveloper/wedevs
chmod +x ./wedevs/*.sh
mv ./wedevs/*.sh /usr/local/bin/
rm -r ./wedevs
Usage
Cloning existing Plugins from SVN into github
You can use the clone-from-svn-to-git.sh script to clone an existing Plugin from the official WordPress repository SVN into github.

.path/to/clone-from-svn-to-git.sh [-p plugin-name] [-a authors-file] [-u svn-username] [-g github-repo-url]

The following are the different options that you can pass to this script.

-p - The name of the Plugin
-a - The path to the authors file. You can find a sample authors file in the root directory of the repo.
-u - The svn username. It is same as your WordPress Plugin repo username.
-g - The url to the github repo. You should have push rights to this repo.
Deploying to SVN repo from Github
You can use the deploy-plugin.sh script to deploy your Plugins to SVN repo, from a git repo.

You don't need to have a copy of this script in every repo. You just need to have one copy of this script somewhere and then you can invoke it from multiple Plugin directories using the following options.

./path/to/deploy-plugin.sh [-p plugin-name] [-u svn-username] [-m main-plugin-file]
        [-a assets-dir-name] [-t tmp directory] [-i make-pot-command] [-h history/changelog file]
        [-r] [-b build-command]
The following are the different options that you can pass to this script.

-p - The name of the Plugin. The script can pick it up from the current directory name
-u - The svn username. It is same as your WordPress Plugin repo username.
-m - The name of the main Plugin file. By default, it is plugin-name.php
-a - The name of the Plugin's assets directory. By default, it is assumed to be assets-wp-repo
-t - Path to the temporary directory. By default /tmp is used
-i - Command to generate pot file.
-h - The name of the History or changelog file. By default HISTORY.md is used.
-r - Whether build command should be run. By default npm run dist is called.
-b - Override build command. This command should place the final files in /dist directory.
Convert readme file from md to txt format and vice versa
You can use the readme-converter.sh script to convert the readme file between WordPress Plugin format and github markdown format. This script also handles screenshots as well.

The deploy-script.sh script automatically does the conversion by using this script.

./path/to/readme-converter.sh [from-file] [to-file] [format to-wp|from-wp]

The following are the different options that you can pass to this script.

The first parameter is the path to the input file
The second parameter is the path to the output file
The third parameter specifies the format. You can use one of the following two.
to-wp - convert from Github markdown format to WordPress Plugin Readme format
from-wp - convert from WordPress Plugin Readme format to Github markdown format
Creating a zip archive of the Plugin
You can use the create-archive.sh script to quickly create a zip archive of the Plugin.

./path/to/create-archive.sh [-p plugin-name] [-o output-dir]

The following are the different options that you can pass to this script.

-p - The name of the Plugin. The script can pick it up from the current directory name
-o - Path to the output directory, where the zip file should be created
Update version string of the Plugin
You can use the update-version.sh script to quickly update the version string of all the files of the Plugin.

./path/to/update-version.sh [old_version] [new_version]

The following are the different options that you can pass to this script.

old_version - Old version string. This string should be escaped. eg: 1.2.3 and not 1.2.3
new_version - New version string. You don't have to escape this
Code Quality Status
The code is pretty stable and I currently use these script for deploying my WordPress Plugins without any major issues. I would however consider the code to be of beta quality status.

Contribution
License
Github Readme Docs
