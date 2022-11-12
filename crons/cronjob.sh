# Delete the content of the tmp folder if the file  is older than 15 min
find ../../www/courseaudrapeau/htdocs/tmp/* -mmin +15 -exec rm {} \;

# */15 * * * * /hosting/www/courseaudrapeau/crons/cronjob.sh