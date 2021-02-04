<?php

namespace Drupal\deployment\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class DeployController.
 */
class DeployController extends ControllerBase {

  /**
   * Deploy.
   *
   *  *
   * Used for automatically deploying  via github
   * User  'nobody' gets grants from 'haimka'
   * Made changes in sudoers file
   * In shell:
     $ sudo visudo
     line 108  - nobody s132-148-89-227.secureserver.net=(haimka) NOPASSWD: ALL
   *
   * Project “YoungIsrael”
  Folders:
  /var/www/html
  File: dpl.php - current file

  /var/www/git-repos/studio/depl.git
  Files:
  deployment-main.sh  - grant permission to deployment-git.sh
  deployment-git.sh – calls git fetch and
  git --work-tree=/var/www/html checkout -f development
   *
   * @return array
   *   Return array.
   */
  public function Deploy() {
    $currentDir = getcwd();
    chdir('/home/sssmz54e2ykb/git-repos/ntdp8/depl.git');
    $shell = shell_exec('./deployment-git.sh');
    chdir($currentDir);

    return [
      '#theme' => ['deployment'],
      '#result' =>$shell,
      '#attached' => [
        'library' => [
        ],
        'drupalSettings'=>[
        ]
      ],
    ];
  }

}
