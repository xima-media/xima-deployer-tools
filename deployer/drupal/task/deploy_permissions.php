<?php

namespace Deployer;

desc('Changing permissions of all directories and files inside drupal directory which are owned by {{user}}');
task('deploy:permissions:drupal', function () {
  writeln('<info>↪ Changing permissions of all directories inside "{{drupal_path}}" which are owned by {{user}} to "rwxr-x---"</info>');
  run ('cd {{drupal_path}} && find . -type d -user {{user}} -exec chmod u=rwx,g=rx,o= \'{}\' \;');

  writeln('<info>↪ Changing permissions of all files inside "{{drupal_path}}" which are owned by {{user}} to "rw-r-----"</info>');
  run ('cd {{drupal_path}} && find . -type f -user {{user}} -exec chmod u=rw,g=r,o= \'{}\' \;');
});

desc('Changing permissions of directories and files of drupal sites "files" directories which are owned by {{user}}');
task('deploy:permissions:drupal_files', function () {
  writeln('<info>↪ Changing permissions of "files" directories in "{{drupal_path}}/sites" which are owned by {{user}} to "rwxrwx---"</info>');
  run ('cd {{drupal_path}}/sites && find . -type d -name files -user {{user}} -exec chmod ug=rwx,o= \'{}\' \;');

  writeln('<info>↪ Changing permissions inside "files" directories in "{{drupal_path}}/sites" of all directories which are owned by {{user}} to "rwxrwx---" and files to "rw-rw----"</info>');
  run ('cd {{drupal_path}}/sites && for x in ./*/files;do find ${x} -type d -user {{user}} -exec chmod ug=rwx,o= \'{}\' \;; find ${x} -type f  -user {{user}} -exec chmod ug=rw,o= \'{}\' \;; done');

  writeln('<info>↪ Changing permissions inside "files" directories in "{{drupal_path}}/sites" of all .htaccess-files which are owned by {{user}} to "rw-r-----"</info>');
  run ('cd {{drupal_path}}/sites && find . -type f -name .htaccess -user {{user}} -exec chmod u=rw,g=r,o= \'{}\' \;');
});
