# Delete the content of the tmp folder if the file  is older than 5 min
find ../tmp/* -mmin +15 -exec rm {} \;