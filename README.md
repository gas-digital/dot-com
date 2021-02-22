# Pull this repo

# Set up your SSH user in the WP-Engine portal
[User Portal](http://my.wpengine.com/)

# Add your git remotes for WP-Engine

`git add remote staging	git@git.wpengine.com:production/socogasstag.git`

`git add remote production	git@git.wpengine.com:production/socogas.git`

# Confirm remotes
`git remote -v`

# Push branch to staging
`git push staging master`

# Push branch to production
`git push production master`
