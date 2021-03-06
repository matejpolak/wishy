@foreach ($news as $key => $new)
    <?php
    switch($new['cathegory'])
    {
        case 'goal':
            $comments = $goal_comments;
            $picture = $new['goal_picture'];
            break;
        case 'post':
            $comments = $post_comments;
            $picture = $new['post_picture'];
            break;
        case 'wish':
            $comments = [];
            $picture = $new['wish_picture'];
            break;
    }

    $this_comments = [];

    foreach($comments as $comment)
    {
        if($comment['target_id'] == $new['id'])
        {
            $this_comments[] = $comment;
        }
    }
    // dd($this_comments);
    $nr_comments = count($this_comments);

    $has_encouraged = Illuminate\Support\Facades\DB::table('encourage_upload')->where([['user_id', Illuminate\Support\Facades\Auth::user()->id], ['upload_id', $new['id']], ['category', $new['cathegory']]])->first();
    ?>
    <div class="post col-12 wishy-rounded wishy-shadow-box-blue bg-light">
        @if(isset($picture))
            <div class="{{$new['cathegory']}}-image">
                <img class="wishy-rounded-top" src="/uploads/{{$picture}}" alt="{{$new['cathegory']}} image">
            </div>
        @endif
        <div class="wishy-post-info">
            <div class="wishy-user-info">
                <div class="profile-post-thumbnail">
                    <img class="profile-thumbnail img-fluid" src="/uploads/{{ $new['profile_picture'] != null ? $new['profile_picture'] : 'profilePictures/default.jpg' }}" alt="Profile Name">
                </div>
                <div class="wishy-user-text">
                    <a href="profile/"><h5>{{$new['user_name']}} {{$new['surname']}}</h5></a>
                    <p>Added at: <span>{{$new['created_at']}}</span></p>
                </div>
                <div class="post-category">
                    @if($new['user_id']==$current_user_id)
                        @if($new['cathegory']=='goal')
                            <a class="btn wishy-btn menu news" href="{{ action('GoalsController@view' , ['id' => $new['id']]) }}"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                        @elseif($new['cathegory']=='wish')
                            <div class="news d-flex">
                                <button class="btn wishy-btn menu editBtn" data-id="{{ $new['id'] }}"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                <form action="{{ action('WishController@destroy', ['id'=> $new['id']]) }}" method="post">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn wishy-btn menu"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                </form>
                            </div>
                        @elseif($new['cathegory']=='post')
                            <div class="news d-flex">
                                <button class="btn wishy-btn menu editBtn" data-id="{{ $new['id'] }}"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                <form action="{{ action('FeedController@destroy', ['id'=> $new['id']]) }}" method="post">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn wishy-btn menu"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                </form>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            <div class="wishy-post-text">
                @if($new['cathegory']=='wish')
                    <form action="{{ action('WishController@update', ['id'=> $new['id']]) }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <h4 class="infoToChange" data-id="{{ $new['id'] }}">
                            @isset($new['name'])
                                {{$new['name']}}
                            @endisset
                        </h4>
                        <input class="infoToChange hidden form-control" data-id="{{ $new['id'] }}" type="text" name="name" value="@isset($new['name']){{ $new['name'] }}@endisset">
                        <p class="infoToChange" data-id="{{ $new['id'] }}">
                            @if( isset($new['description']))
                                {{$new['description']}}
                            @else
                                {{ 'Some description' }}
                            @endif
                        </p>
                        <input class="infoToChange hidden form-control" data-id="{{ $new['id'] }}" type="text" name="description" value="@if( isset($new['description'])){{ $new['description'] }}@endif">
                        <div class="infoToChange hidden form-group" data-id="{{ $new['id'] }}">
                            <div class="row mt-1">
                                <div class="col-4">
                                    <label for="is_public">Make it public? </label>
                                </div>
                                <div class="col-6 mt-1">
                                    <input name="is_public" type="checkbox" class="form-control" id="is_public" <?= ($new['is_public'] == 1) ? 'checked' : '' ?>>
                                </div>
                            </div>
                        </div>
                        <div class="form-group infoToChange hidden" data-id="{{ $new['id'] }}">
                            <label for="wish_picture">Wish Picture</label>
                            <div class="col">
                                <input name="wish_picture" type="file" class="form-control" id="wish_picture" value="{{ $new['wish_picture'] }}">
                            </div>
                        </div>
                        <button type="submit" class="infoToChange hidden form-group btn wishy-btn" data-id="{{ $new['id'] }}">Save Changes</button>
                    </form>
                @elseif($new['cathegory']=='post')
                    <form action="{{ action('FeedController@update', ['id'=> $new['id']]) }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <p class="infoToChange" data-id="{{ $new['id'] }}">
                            @if( isset($new['description']))
                                {{$new['description']}}
                            @else
                                {{ 'Some description' }}
                            @endif
                        </p>
                        <input class="infoToChange hidden form-control" data-id="{{ $new['id'] }}" type="text" name="description" value="@if( isset($new['description'])){{ $new['description'] }}@endif">
                        <div class="form-group infoToChange hidden" data-id="{{ $new['id'] }}">
                            <label for="post_picture">Post Picture</label>
                            <div class="col">
                                <input name="post_picture" type="file" class="form-control" id="post_picture" value="{{ $new['post_picture'] }}">
                            </div>
                        </div>
                        <button type="submit" class="infoToChange hidden form-group btn wishy-btn" data-id="{{ $new['id'] }}">Save Changes</button>
                    </form>
                @elseif($new['cathegory']=='goal')
                    <h4 class="infoToChange" data-id="{{ $new['id'] }}">
                        @isset($new['name'])
                            {{$new['name']}}
                        @endisset
                    </h4>
                    <p class="infoToChange" data-id="{{ $new['id'] }}">
                        @if( isset($new['description']))
                            {{$new['description']}}
                        @else
                            {{ 'Some description' }}
                        @endif
                    </p>
                @endif
            </div>
        </div>
        <div class="wishy-post-nav wishy-rounded-bottom">
            <div class="default" data-mat="{{ $key }}">
                @isset($new['tag'])
                    <a href="#" title="Status" class="status mr-3"><i class="fa fa-certificate mr-1" aria-hidden="true"></i>{{$new['tag']}}</a>
                @endisset
                <a href="#" class="encourage" title="Encourage" data-id="{{ $new['id'] }}" data-category="{{ $new['cathegory'] }}"><i class="fa fa-hand-peace-o mr-1" aria-hidden="true"></i><span class="encourage_text">{{ empty($has_encouraged) ? 'Encourage ' : 'Encouraged ' }}</span><span class="encourage_number">({{$new['nr_encouragements']}})</span></a>
                @if($new['cathegory']=='goal' || $new['cathegory']=='post')
                    <a href="#" data-mat="{{ $key }}" class="comment ml-3 startComment"><i class="fa fa-commenting-o mr-1" aria-hidden="true"></i>Comment ({{$nr_comments}})</a>
                @endif

            </div>

            @if($new['cathegory']=='goal' || $new['cathegory']=='post')

                <div class="commenting col-12" data-mat="{{ $key }}">

                    <div class="row">
                        <div class="col-11">
                            <form class="w-100" action="{{ action('CommentController@new', ['post_id' => $new['id'], 'type' => $new['cathegory']])}}" method="post">
                                <div class="row">
                                    <div class="col-10">
                                        <input class="w-100" type="text" name="text" placeholder="Add new comment">
                                    </div>
                                    <div class="col-2">
                                        <button data-category="{{$new['cathegory']}}" class="commenting-buttons btn wishy-btn menu" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-1">
                            <button style="position: static; margin-left: -20px;" title="Close" class="btn wishy-btn menu closingButton" data-mat="{{ $key }}"><i class="fa fa-times" aria-hidden="true"></i></button>
                        </div>
                    </div>

                </div>
            @endif
        </div>
        <div class="comments main wishy-rounded-bottom" id="comment-section" data-mat="{{ $key }}">
            @foreach($this_comments as $this_comment)
                <div class="comments row">
                    <div class="col">
                        <img class="comment-profile-image img-fluid" src="/uploads/{{ $this_comment['profile_picture'] != null ? $this_comment['profile_picture'] : 'profilePictures/default.jpg' }}" alt="Profile picture">
                    </div>

                    <div class="col-7">
                        <h5>{{$this_comment['name']}} {{$this_comment['surname']}}</h5>
                        <sub>Added at: <span>{{$this_comment['created_at']}}</span></sub>
                        <p data-comment="{{ $this_comment['id'] }}">{{$this_comment['text']}}</p>
                        <div class="editing" data-comment="{{ $this_comment['id'] }}">
                            <form action="{{action('CommentController@update', ['id' => $this_comment['id']])}}">
                                <input type="text" name="text" value="{{$this_comment['text']}}">
                                <button style="position: static" class="comment_update btn wishy-btn green menu" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                            </form>
                        </div>
                    </div>

                    <div class="col-3 d-flex">
                        @if($this_comment['user_id'] == $current_user_id)
                            <div class="links d-flex flex-row align-items-center">
                                <button class="comment_edit btn wishy-btn green menu editBtn" data-comment="{{ $this_comment['id'] }}"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                <a role="button" class="comment_delete btn wishy-btn green menu" href="{{action('CommentController@destroy', ['id' => $this_comment['id']])}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </div>
                        @endif
                    </div>

                </div>
                <hr>
            @endforeach
        </div>
    </div>
@endforeach
<script>
    $('.editBtn').click(function() {
        var id = $(this).data('id');
        $('.infoToChange[data-id='+ id +']').toggleClass('hidden');
    })
</script>
