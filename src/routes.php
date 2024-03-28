<?php

use think\facade\Route;

Route::rule(config('graphql.route'), thinkGql\GraphQLController::class . '@query');
