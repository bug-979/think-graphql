<?php

use think\facade\Route;

Route::rule('gql', thinkGql\GraphQLController::class . '@query');
