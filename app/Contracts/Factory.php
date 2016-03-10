<?php
namespace App\Contracts;

/**
 * Interface Factory
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package focusLeagu\App\Factories
 * @author Asif Mohammed <asifm42@gmail.com>
 */
interface Factory {

  /**
   * Make a new user entity
   *
   * @param array $data
   * @return Illuminate\Database\Eloquent\Model
   */
  public function make(array $data);
}