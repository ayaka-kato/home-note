@extends('adminlte::page')

@section('title', 'レシピ編集')

@section('content_header')
    <h1>レシピ編集</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-10">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">レシピ編集</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <form action=" {{ url('/delete-recipe/' . $recipe->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除していいですか？')">レシピ削除</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ url('/update-recipe') }}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="card-body d-flex">
                            <div class="col-md-7">
                                <h2 class="mb-1 recipe-name"><input type="text" name="name" class="form-control" id="name" value="{{ $recipe->name }}"></h2>
                                <div class="form-group">
                                    <div class="form-group">
                                        <!-- Collapse ボタン -->
                                        <a class="btn btn-success" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">カテゴリを変更する</a>
                                        <span>現在のカテゴリ：{{ $recipe->category }}</span>
                                        <!-- Collapse コンテンツ -->
                                        <div class="collapse multi-collapse" id="multiCollapseExample1">
                                            <div class="card card-body food-select-area">
                                                <div class="row">
                                                    <div>
                                                        <label for="type-0" class="mr-2"><input type="radio" name="category" id="type-0" value="主食(ご飯)" {{ $recipe->category == "主食(ご飯)" ? "checked": null}}>主食(ご飯)</label>
                                                        <label for="type-1" class="mr-2"><input type="radio" name="category" id="type-1" value="主食(パン)" {{ $recipe->category == "主食(パン)" ? "checked": null}}>主食(パン)</label>
                                                        <label for="type-2" class="mr-2"><input type="radio" name="category" id="type-2" value="主食(めん)" {{ $recipe->category == "主食(めん)" ? "checked": null}}>主食(めん)</label>
                                                        <label for="type-3" class="mr-2"><input type="radio" name="category" id="type-3" value="主食(その他)" {{ $recipe->category == "主食(その他)" ? "checked": null}}>主食(その他)</label>
                                                        <label for="type-4" class="mr-2"><input type="radio" name="category" id="type-4" value="主菜(肉)" {{ $recipe->category == "主菜(肉)" ? "checked": null}}>主菜(肉)</label>
                                                        <label for="type-5" class="mr-2"><input type="radio" name="category" id="type-5" value="主菜(魚)" {{ $recipe->category == "主菜(魚)" ? "checked": null}}>主菜(魚)</label>
                                                        <label for="type-6" class="mr-2"><input type="radio" name="category" id="type-6" value="主菜(卵)" {{ $recipe->category == "主菜(卵)" ? "checked": null}}>主菜(卵)</label>
                                                        <label for="type-7" class="mr-2"><input type="radio" name="category" id="type-7" value="副菜(野菜)" {{ $recipe->category == "副菜(野菜)" ? "checked": null}}>副菜(野菜)</label>
                                                        <label for="type-7" class="mr-2"><input type="radio" name="category" id="type-8" value="副菜(きのこ)" {{ $recipe->category == "副菜(きのこ)" ? "checked": null}}>副菜(きのこ)</label>
                                                        <label for="type-7" class="mr-2"><input type="radio" name="category" id="type-9" value="副菜(海藻)" {{ $recipe->category == "副菜(海藻)" ? "checked": null}}>副菜(海藻)</label>
                                                        <label for="type-7" class="mr-2"><input type="radio" name="category" id="type-10" value="副菜(その他)" {{ $recipe->category == "副菜(その他)" ? "checked": null}}>副菜(その他)</label>
                                                        <label for="type-7" class="mr-2"><input type="radio" name="category" id="type-11" value="スープ" {{ $recipe->category == "スープ" ? "checked": null}}>スープ</label>
                                                        <label for="type-7" class="mr-2"><input type="radio" name="category" id="type-12" value="デザート" {{ $recipe->category == "デザート" ? "checked": null}}>デザート</label>
                                                        <label for="type-8" class="mr-2"><input type="radio" name="category" id="type-13" value="その他" {{ $recipe->category == "その他" ? "checked": null}}>その他</label>
                                                    </div>
                                                    <p class="error-msg">{{ $errors->first('text') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group"><div class="">レビュー</div></div>

                                <!-- 画像 -->
                                <div class="form-group">
                                    <div class="recipe-image my-3">                                        
                                        <div id="previewImage"><img src="data:image/png;base64,{{ $recipe->image }}" alt="レシピ写真"></div>
                                        <p class="my-1">画像：</p>
                                        <input type="file" class="form-control" id="image" name="image" value="{{ old('image') }}">                                
                                    </div>
                                </div>

                                <!-- リンク・共有 -->
                                <p class="my-1">参考リンク：<input type="text" name="link" id="link" class="form-control" value="{{ $recipe->link }}"></p>
                            </div>
        
                            <!-- 材料 -->
                            <div class="col-md-4 food-ready-area ml-5">
                                <div class="row">
                                    <h4 class="mt-2">材料</h4>
                                    @php $colCount = 0; @endphp
                                    @foreach ($recipe->foods as $food)
                                    <p class="food-border">{{ $food->name }}</p>

                                    @endforeach
                                </div>

                                <div class="form-group">
                                    <!-- Collapse ボタン -->
                                    <button class="btn btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">追加する</button>
                                    <a href="{{ url('/create-food') }}">食材の登録をする</a>

                                    <!-- Collapse コンテンツ -->
                                    <div class="collapse multi-collapse" id="multiCollapseExample2">
                                        <div class="card card-body food-select-area">
                                            <div class="row">
                                                <p class="color-red">*10個まで選択可能</p>
                                                @foreach($types as $type)
                                                <b class="border-bottom pb-1 mb-1">{{$type}}</b>                                        
                                                    @php $colCount = 0; @endphp
                                                    @foreach($foods as $food)
                                                    @if($type == $food->type)
                                                        <div class="col-md-4">
                                                            <label for="food_{{ $food->id }}" class="food-label font-weight-normal">{{ $food->name }}</label>
                                                            <input type="checkbox" name="food[]" value="{{ $food->id }}" id="food_{{ $food->id }}">
                                                        </div>

                                                        <!-- 列が3列並んだ時、新しい行が作られる -->
                                                        @php $colCount++; @endphp
                                                        @if($colCount % 3 == 0)
                                                            </div><div class="row">
                                                        @endif
                                                    @endif
                                                    @endforeach
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <div class="col-md-12 dot-border">
                                <h4>作り方</h4>
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="col-md-2">順番</th>
                                            <th class="col-md-4">手順</th>
                                            <th class="col-md-6">詳細</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @for ($i = 0; $i < 8; $i++)
                                    @php
                                        $heading = 'heading_' . $i;
                                        $detail = 'detail_' . $i;
                                    @endphp
                                    @if(isset($recipe->{$heading}) || isset($recipe->{$detail}))
                                        <tr>
                                            <td class="col-md-2">{{$i+1}}</td>
                                            <td class="col-md-4"><input type="text" class="form-control" value="{{ $recipe->{$heading} }}"></td>
                                            <td class="col-md-6"><input type="textarea" class="form-control" value="{{ $recipe->{$detail} }}"></td>
                                        </tr>
                                    @endif
                                    </tbody>
                                    @endfor
                                </table>                                        
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">更新</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="scroll-btn-area">
                <button onclick="scrollToBottom()" class="btn btn-scroll top"><img src="{{ asset('img/arrow-down-circle.svg') }}" alt="画面下へスクロールするアイコン"></button>
                <button onclick="scrollToTop()" class="btn btn-scroll bottom"><img src="{{ asset('img/arrow-up-circle.svg') }}" alt="画面上へスクロールするアイコン"></button>
            </div>
        </div>
    </div>


    <div class="row">

    </div>
@stop

@section('css')
@stop

@section('js')
@stop
