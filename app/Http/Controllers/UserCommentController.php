<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\CommentResource;
use Illuminate\Support\Facades\DB;

class UserCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $comments = $user->comments()->latest()->withTrashed()->has('post.image')->get();

        // пункт 7.1
        // $comments = DB::select('select * from "comments" where "comments"."commentator_id" = ? and "comments"."commentator_id" is not null and exists (select * from "posts" where "comments"."post_id" = "posts"."id" and exists (select * from "images" where "posts"."image_id" = "images"."id") and "posts"."deleted_at" is null) order by "created_at" desc', [$user->id]);

        return CommentResource::collection($comments);
    }

}
