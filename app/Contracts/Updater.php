<?php
namespace App\Contracts;

/**
 * Interface Updater
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package ObsidianLearning\Black\Contracts
 * @author Asif Mohammed <asifm@obsidianlearning.com>
 */
interface Updater {

  /**
   * Update the user entity
   *
   * @param array $data
   * @return Illuminate\Database\Eloquent\Model
   */
  public function update($id, array $data);
}