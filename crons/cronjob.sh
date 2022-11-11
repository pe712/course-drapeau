# Delete the content of the tmp folder if the file  is older than 15 min
find ../htdocs/tmp/* -mmin +15 -exec rm {} \;