<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Comments
 *
 * @property int $id
 * @property int $user_id
 * @property int $media_id
 * @property string $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\CommentsFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Comments newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comments newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comments query()
 * @method static \Illuminate\Database\Eloquent\Builder|Comments whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comments whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comments whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comments whereMediaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comments whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comments whereUserId($value)
 */
	class Comments extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Friend_request
 *
 * @property int $id
 * @property int $user_id
 * @property int $requested_user_id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Friend_request newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Friend_request newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Friend_request query()
 * @method static \Illuminate\Database\Eloquent\Builder|Friend_request whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Friend_request whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Friend_request whereRequestedUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Friend_request whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Friend_request whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Friend_request whereUserId($value)
 */
	class Friend_request extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Friends
 *
 * @property int $id
 * @property int $user_id
 * @property int $friend_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\FriendsFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Friends newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Friends newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Friends query()
 * @method static \Illuminate\Database\Eloquent\Builder|Friends whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Friends whereFriendId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Friends whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Friends whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Friends whereUserId($value)
 */
	class Friends extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Likes
 *
 * @property int $id
 * @property int $user_id
 * @property int $media_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\LikesFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Likes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Likes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Likes query()
 * @method static \Illuminate\Database\Eloquent\Builder|Likes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Likes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Likes whereMediaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Likes whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Likes whereUserId($value)
 */
	class Likes extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Media
 *
 * @property int $id
 * @property int $user_id
 * @property string $caption
 * @property string $image_path
 * @property int $width
 * @property int $height
 * @property string|null $position
 * @property string|null $anchor_id
 * @property string|null $anchor_name
 * @property int $compass_direction
 * @property int $total_comments
 * @property int $total_likes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comments[] $comments
 * @property-read int|null $comments_count
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media comparison($geometryColumn, $geometry, $relationship)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media contains($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media crosses($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media disjoint($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media distance($geometryColumn, $geometry, $distance)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media distanceExcludingSelf($geometryColumn, $geometry, $distance)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media distanceSphere($geometryColumn, $geometry, $distance)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media distanceSphereExcludingSelf($geometryColumn, $geometry, $distance)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media distanceSphereValue($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media distanceValue($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media doesTouch($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media equals($geometryColumn, $geometry)
 * @method static \Database\Factories\MediaFactory factory(...$parameters)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media intersects($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media newModelQuery()
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media newQuery()
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media orderByDistance($geometryColumn, $geometry, $direction = 'asc')
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media orderByDistanceSphere($geometryColumn, $geometry, $direction = 'asc')
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media orderBySpatial($geometryColumn, $geometry, $orderFunction, $direction = 'asc')
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media overlaps($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media query()
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media whereAnchorId($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media whereAnchorName($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media whereCaption($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media whereCompassDirection($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media whereCreatedAt($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media whereHeight($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media whereId($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media whereImagePath($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media wherePosition($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media whereTotalComments($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media whereTotalLikes($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media whereUpdatedAt($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media whereUserId($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media whereWidth($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Media within($geometryColumn, $polygon)
 */
	class Media extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Unlocked
 *
 * @property int $id
 * @property int $user_id
 * @property int $media_id
 * @property int $friend_id
 * @property int $media_unlocked
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\UnlockedFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Unlocked newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Unlocked newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Unlocked query()
 * @method static \Illuminate\Database\Eloquent\Builder|Unlocked whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unlocked whereFriendId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unlocked whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unlocked whereMediaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unlocked whereMediaUnlocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unlocked whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unlocked whereUserId($value)
 */
	class Unlocked extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $username
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $user_dp
 * @property string|null $user_location
 * @property int $user_avatar
 * @property int $active
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Friend_request[] $friend_request
 * @property-read int|null $friend_request_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Friends[] $friends
 * @property-read int|null $friends_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Likes[] $likes
 * @property-read int|null $likes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Media[] $medias
 * @property-read int|null $medias_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Unlocked[] $unlocked
 * @property-read int|null $unlocked_count
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User comparison($geometryColumn, $geometry, $relationship)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User contains($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User crosses($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User disjoint($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User distance($geometryColumn, $geometry, $distance)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User distanceExcludingSelf($geometryColumn, $geometry, $distance)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User distanceSphere($geometryColumn, $geometry, $distance)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User distanceSphereExcludingSelf($geometryColumn, $geometry, $distance)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User distanceSphereValue($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User distanceValue($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User doesTouch($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User equals($geometryColumn, $geometry)
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User intersects($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User newModelQuery()
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User newQuery()
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User orderByDistance($geometryColumn, $geometry, $direction = 'asc')
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User orderByDistanceSphere($geometryColumn, $geometry, $direction = 'asc')
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User orderBySpatial($geometryColumn, $geometry, $orderFunction, $direction = 'asc')
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User overlaps($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User query()
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User whereActive($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User whereEmail($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User whereId($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User whereName($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User wherePassword($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User whereUserAvatar($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User whereUserDp($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User whereUserLocation($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User whereUsername($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User within($geometryColumn, $polygon)
 */
	class User extends \Eloquent {}
}

