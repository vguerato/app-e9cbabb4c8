#!/bin/bash
hash="$(echo $RANDOM | md5sum | head -c 10)"
name="app-$hash"
dir="$name"
user=""
auth=""
publish=false

args=$(getopt --name "$0" --options n:d:p:u:t: -- "$@")
eval set -- "$args"

while [[ $# -gt 0 ]]; do 
	case "$1" in
		-n) name=$2; shift 1;;
		-d) dir=$2; shift 1;;
		-p) publish=true; shift 1;;
		-u) user=$2; auth=$user; shift 1;;
		-t) auth="$user:$(<$2)"; shift 1;;
		*) shift;;
	esac
done

echo "Repo: $name | dir: $dir | publish: $publish | user: $user | token: $token";

# Publish on github
if [[ $publish == true ]];
then
	# Create or open project directory
    if [[ $dir != '.' ]];
    then
		mkdir -p $dir
    fi
    
	cd $dir

	# Create repository using github api
    curl -u $auth https://api.github.com/user/repos -d "{\"name\": \"$name\"}"
    repo_url="github.com/$user/$name.git"
    echo "Repository $name created: $url"
    
    if [! -f "$dir/README.md" ]; then 
    	echo "Repository: $name | Hash: $hash | Generated: $(date)" > README.md
    fi
    
    # Publish repository and branches
    rm -rf .git
    git init    
    git add .
    git commit -m "first commit"
    git branch -M master
    git remote add origin "https://$repo_url"
    git push "https://$auth@$repo_url"    
    
    echo "Repository $name published"
fi
