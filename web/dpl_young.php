<?php
/**
 * GIT DEPLOYMENT SCRIPT
 *
 * Used for automatically deploying  via github
 * User  'nobody' gets grants from 'haimka'
 * Made changes in sudoers file
 * In shell:
    $ sudo visudo
     line 108  - nobody s132-148-89-227.secureserver.net=(haimka) NOPASSWD: ALL
 *
 * Project “Studio”
        Folders:
        /var/www/html
            File: dpl.php - current file

        /var/www/git-repos/studio/depl.git
            Files:
                deployment-main.sh  - grant permission to deployment-git.sh
                deployment-git.sh – calls git fetch and
                   git --work-tree=/var/www/html checkout -f development
 *
 *
 *
 */

chdir('/home/git-repos/cars4lessny/depl.git');
$shell = shell_exec('./deployment-main.sh');

?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>GIT DEPLOYMENT SCRIPT</title>
</head>
<body style="background-color: #000000; color: #FFFFFF; font-weight: bold; padding: 0 10px;">
<pre>
 .  ____  .    ____________________________
 |/      \|   |                            |
[| <span style="color: #FF0000;">&hearts;    &hearts;</span> |]  | Git Deployment Script v1.0 |
 |___==___|  /       &copy; Reuven770 2020      |
              |____________________________|

<?php echo $shell; ?>
</pre>
</body>
</html>
