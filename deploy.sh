#!/bin/bash
plugin_dir=$(pwd)
plugin_slug="$(basename $plugin_dir)"
js_dirs=("./assets/js/")
plugin_file="./${plugin_slug}.php"
task=$1

#get version
#version=$(cat ${plugin_file} | grep "Version:" | cut -d ":" -f 2 | sed -e 's/^[ \t]*//')

if [ -z "$task" ]
then
	task="deploy"
fi

if [ $task = "deploy" ] || [ $task = "min" ]
then
	echo "Running (min) task"
	#minimize JavaScript
	for js_dir in "${js_dirs[@]}"
	do
		rm ${js_dir}*.min.js;
		for f in ${js_dir}*.js;
			do short=${f%.js};
			uglifyjs ${f} --compress --mangle --output ${short}.min.js;
			echo "File ${short}.js minimize."
		done
	done
fi

if [ $task = "deploy" ] || [ $task = "pot" ]
then
    echo "Running (pot) task"
	#text domain
	text_domain=$(cat ${plugin_file} | grep "Text Domain:" | cut -d ":" -f 2 | sed -e 's/^[ \t]*//')
	#pot file.
	wp i18n make-pot . languages/${text_domain}.pot
fi

if [ $task = "deploy" ] || [ $task = "zip" ]
then
	echo "Running (zip) task"
	#zip
	cd ..
	zip -r /var/www/public/${plugin_slug}.zip ${plugin_slug} -x "*node_modules/*" "*.git/*" "*deploy/*" "*deploy.sh" "*Gruntfile.js" "*readme.md" "*README.md" "*package.json" "*.gitignore" "*phpcs.xml*"
fi