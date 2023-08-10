@extends('adminlte::page')

@section('title', 'レシピ登録')

@section('content_header')
    <h1>レシピ登録</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card card-primary">
                <form method="POST" action="{{ url('/store-recipe') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">レシピ名<span class="color-red">*必須</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="（例）肉じゃが" value="{{ old('name') }}" autofocus>
                        </div>

                        <div class="form-group">
                            <label>カテゴリ</label>
                            <!-- Collapse ボタン -->
                            <a class="btn btn-success" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">選択する</a>

                            <!-- Collapse コンテンツ -->
                            <div class="collapse multi-collapse" id="multiCollapseExample1">
                                <div class="card card-body food-select-area">
                                    <div class="row">
                                        <div>
                                            <label for="type-0" class="mr-2"><input type="radio" name="category" id="type-0" value="主食(ご飯)" {{ old('type') == "主食(ご飯)" ? "checked": null}}>主食(ご飯)</label>
                                            <label for="type-1" class="mr-2"><input type="radio" name="category" id="type-1" value="主食(パン)" {{ old('type') == "主食(パン)" ? "checked": null}}>主食(パン)</label>
                                            <label for="type-2" class="mr-2"><input type="radio" name="category" id="type-2" value="主食(めん)" {{ old('type') == "主食(めん)" ? "checked": null}}>主食(めん)</label>
                                            <label for="type-3" class="mr-2"><input type="radio" name="category" id="type-3" value="主食(その他)" {{ old('type') == "主食(その他)" ? "checked": null}}>主食(その他)</label>
                                            <label for="type-4" class="mr-2"><input type="radio" name="category" id="type-4" value="主菜(肉)" {{ old('type') == "主菜(肉)" ? "checked": null}}>主菜(肉)</label>
                                            <label for="type-5" class="mr-2"><input type="radio" name="category" id="type-5" value="主菜(魚)" {{ old('type') == "主菜(魚)" ? "checked": null}}>主菜(魚)</label>
                                            <label for="type-6" class="mr-2"><input type="radio" name="category" id="type-6" value="主菜(卵)" {{ old('type') == "主菜(卵)" ? "checked": null}}>主菜(卵)</label>
                                            <label for="type-7" class="mr-2"><input type="radio" name="category" id="type-7" value="副菜(野菜)" {{ old('type') == "副菜(野菜)" ? "checked": null}}>副菜(野菜)</label>
                                            <label for="type-7" class="mr-2"><input type="radio" name="category" id="type-8" value="副菜(きのこ)" {{ old('type') == "副菜(きのこ)" ? "checked": null}}>副菜(きのこ)</label>
                                            <label for="type-7" class="mr-2"><input type="radio" name="category" id="type-9" value="副菜(海藻)" {{ old('type') == "副菜(海藻)" ? "checked": null}}>副菜(海藻)</label>
                                            <label for="type-7" class="mr-2"><input type="radio" name="category" id="type-10" value="副菜(その他)" {{ old('type') == "副菜(その他)" ? "checked": null}}>副菜(その他)</label>
                                            <label for="type-7" class="mr-2"><input type="radio" name="category" id="type-11" value="スープ" {{ old('type') == "スープ" ? "checked": null}}>スープ</label>
                                            <label for="type-7" class="mr-2"><input type="radio" name="category" id="type-12" value="デザート" {{ old('type') == "デザート" ? "checked": null}}>デザート</label>
                                            <label for="type-8" class="mr-2"><input type="radio" name="category" id="type-13" value="その他" {{ old('type') == "その他" ? "checked": null}}>その他</label>
                                        </div>
                                        <p class="error-msg">{{ $errors->first('text') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>食材</label>
                            <!-- Collapse ボタン -->
                            <button class="btn btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">選択する</button>
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
                        <div class="form-group">
                            <label for="link">参考リンク</label>
                            <input type="text" class="form-control" id="link" name="link" placeholder="（例）https//..." value="{{ old('link') }}">
                        </div>
                        <div class="form-group">
                            <label for="image">画像</label>
                            <div id="previewImage"></div>
                            <input type="file" class="form-control" id="image" name="image" value="{{ old('image') }}">
                        </div>

                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th class="col-md-2">順番</th>
                                    <th class="col-md-4">工程</th>
                                    <th class="col-md-6">詳細</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="col-md-2">1</td>
                                    <td class="col-md-4">
                                        <input type="text" class="form-control" name="heading-0" placeholder="（例）下準備" value="{{ old('heading-0') }}">
                                    </td>
                                    <td class="col-md-6">
                                        <textarea type="text" class="form-control" name="detail-0" placeholder="（例）一口サイズに切る" value="{{ old('detail-0') }}"></textarea>
                                    </td>
                                    <td class="col-md-1">
                                        <button type="button" class="btn btn-success add-Btn" id="addBtn-0" data-id="0">追加</button>
                                    </td>
                                </tr>
                                @for ($i = 1; $i < 8; $i++)
                                <tr id="addForm-{{ $i }}" class="addForm" style="display:none;">
                                    <td class="col-md-1">{{$i+1}}</td>
                                    <td class="col-md-4">
                                        <input type="text" class="form-control" name="heading-{{ $i }}" id="heading-{{ $i }}" value="{{ old('heading-'. $i ) }}">
                                    </td>
                                    <td class="col-md-5">
                                        <textarea type="text" class="form-control" name="detail-{{ $i }}" id="detail-{{ $i }}" value="{{ old('detail-'. $i ) }}"></textarea>
                                    </td>

                                    @if($i == 7)
                                    <!-- <button type="button" class="btn add-Btn" id="addBtn-{{ $i }}" data-id="{{ $i }}">入力欄{{ $i + 2 }}を追加</button> -->
                                    @else
                                    <td class="col-md-1">
                                        <button type="button" class="btn btn-success add-Btn" id="addBtn-{{ $i }}" data-id="{{ $i }}">追加</button>
                                    </td>
                                    <td class="col-md-1">
                                        <button type="button" class="btn btn-danger delete-Btn" id="deleteBtn-{{ $i }}" data-id="{{ $i }}">削除</button>
                                    </td>
                                    @endif
                                </tr>
                                @endfor
                            </tbody>
                        </table>   
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">登録</button>
                    </div>
                </form>
            </div>
            <div class="scroll-btn-area">
                <button onclick="scrollToBottom()" class="btn btn-scroll top"><img src="{{ asset('img/arrow-down-circle.svg') }}" alt="画面下へスクロールするアイコン"></button>
                <button onclick="scrollToTop()" class="btn btn-scroll bottom"><img src="{{ asset('img/arrow-up-circle.svg') }}" alt="画面上へスクロールするアイコン"></button>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
