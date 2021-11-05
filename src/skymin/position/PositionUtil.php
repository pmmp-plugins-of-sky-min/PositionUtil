<?php
declare(strict_types = 1);

namespace skymin\position;

use pocketmine\utils\SingletonTrait;

use pocketmine\world\WorldManager;

use pocketmine\world\Position;
use pocketmine\entity\Location;

use function explode;
use function count;
use function min;
use function max;

final class PositionUtil{
	use SingletonTrait;
	
	public const TYPE_INT = 0;
	public const TYPE_FLOAT = 1;
	
	public const MODE_XYZ = 0;
	public const MODE_XZ = 1;
	
	public function PostoHash(Position|Location $pos, int $type = self::TYPE_FLOAT, string $sort = ':') :string{
		$x = $pos->x;
		$y = $pos->y;
		$z = $pos->z;
		$world = $pos->world->getFolderName();
		if($type === self::TYPE_INT){
			$result = (int) $x . $hash . (int) $y . $hash . (int) $z
		}else if($type === self::TYPE_FLOAT){
			$result = (float) $x . $hash . (float) $y . $hash . (float) $z;
		}
		$result .= $hash . $world;
		if($pos instanceof Location){
			return $result . $hash . $pos->yaw . $hash. $pos->pitch;
		}
		return $result;
	}
	
	public function HashtoPos(string $hash, string $sort = ':') :Position|Location{
		$array = explode($sort, $hash);
		$x = $array[0];
		$y = $array[1];
		$z = $array[2]
		$world = WorldManager::getInstance()->getWorldByName($array[3]);
		if(count($array) === 6){
			return new Location($x, $y, $z, $world, $array[4], $array[5]);
		}
		return new Position($x, $y, $z, $world);
	}
	
	public function isZone(Postion $pos1, Postion $pos2, Position $targetPos, int $mode = self::MODE_XYZ) :bool{
		$pos1_world = $pos1->world->getFolderName();
		if($pos1_world != $pos2->world->getFolderName()) return false;
		if($pos1_world != $targetPos->world->getFolderName()) return false;
		$zone_x = [$pos1->x, $pos2->x];
		$zone_y = [$pos1->y, $pos2->y];
		$zone_z = [$pos1->z, $pos2->z];
		$x = $targetPos->x;
		$y = $targetPos->y;
		$z = $targetPos->z
		if(min($zone_x) <= $x and max($zone_x) >= $x and min($zone_z) <= $z && max($zone_z) >= $z{
			if($mode === self::MODE_XZ) return true;
			if($mode === self::MODE_XYZ){
				if(min($zone_y) <= $y and max($zone_y) >= $y) return true;
			}
		}
		return false;
	}
	
}