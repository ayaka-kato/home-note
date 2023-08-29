@extends('adminlte::page')

@section('title', 'レシピ編集')

@section('content_header')
<div id="edit-recipe" class="d-flex">
    <h1>レシピ編集</h1>
    <div class="right-btn">
        <form action=" {{ route('deleteRecipe', [ 'id' => $recipe->id ] ) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除していいですか？')">レシピ削除</button>
        </form>
    </div>
</div>
@stop

@section('content')
    <div class="row">
        <div class="col-12 col-md-11">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div class="card">
                <div class="card-body info-process">
                    <form action="{{ route('updateRecipe', [ 'id' => $recipe->id ] ) }}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="info-area">
                            <div class="col-10 col-md-7">
                                <h2 class="mb-1 recipe-name"><input type="text" name="name" class="form-control" id="name" value="{{ $recipe->name }}"></h2>
                                <div class="form-group category-area">
                                    <!-- Collapse ボタン -->
                                    <a class="btn btn-success" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">カテゴリを変更</a>
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

                                <!-- 画像 -->
                                <div class="form-group">
                                    <div id="previewImage">
                                        @if( $recipe->image)
                                        <img src="data:image/png;base64,{{ $recipe->image }}" alt="レシピ写真">
                                        @else
                                        <img src="{{ asset('img/no-image.png') }}" alt="レシピ写真">
                                        @endif
                                    </div>
                                    <p class="my-1">画像：</p>
                                    <input type="file" class="form-control" id="image" name="image" value="{{ old('image') }}">                                
                                </div>

                                <!-- リンク・共有 -->
                                <p class="my-1">参考リンク：<input type="text" name="link" id="link" class="form-control" value="{{ old('link', $recipe->link) }}"></p>
                            </div>

                            <!-- 材料 -->
                            <div class="col-11 col-md-4 food-ready-area mx-3">
                                <div class="row">
                                    <h4 class="mt-2">材料</h4>
                                    <div class="col-12 d-flex">
                                        <label for="serving" class="col-3 col-sm-2 col-md-5 serving font-normal">何人前：</label>
                                        <input type="text" class="form-control col-8 col-sm-4 col-md-7" name="serving" id="serving" value="{{ old('serving', $recipe->serving)}}">
                                    </div>
                                    <table class="">
                                        <thead>
                                            <tr>
                                                <th class="col-5 font-normal">食材</th>
                                                <th class="col-5 font-normal">分量</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- 登録済みの食材データ -->
                                            @foreach ($ingredients as $index => $ingredient)
                                            <tr class="ingredient">
                                                <td class="col-5"><input type="text" class="form-control" id="ingredient-{{ $index }}" name="ingredient-{{ $index }}" value="{{ old('ingredient-' . $index, $ingredient['ingredient']) }}"></td>
                                                <td class="col-5"><input type="text" class="form-control" id="amount-{{ $index }}" name="amount-{{ $index }}" value="{{ old('amount-' . $index, $ingredient['amount']) }}"></td>
                                                <td class="col-1"><button type="button" class="btn clearIngredientBtn" data-id="{{ $index }}">×</button></td>
                                            </tr>
                                            @endforeach

                                            <!-- 新規登録の食材フォーム -->
                                            @for( $i = $ingredients->count() ; $i < 20; $i++)
                                            <tr class="ingredient" style="display:none;">
                                                <td class="col-5"><input type="text" class="form-control" id="ingredient-{{ $i }}" name="ingredient-{{ $i }}" value="{{ old('ingredient-' . $i) }}"></td>
                                                <td class="col-5"><input type="text" class="form-control" id="amount-{{ $i }}" name="amount-{{ $i }}" value="{{ old('amount-' . $i) }}"></td>
                                                <td class="col-1"><button type="button" class="btn clearIngredientBtn" data-id="{{ $i }}">×</button></td>
                                            </tr>
                                            @endfor
                                            <tr>
                                                <td><button type="button" class="btn btn-success" id="addIngredientBtn">食材を追加</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card-body process-area">
                            <div class="col-12 dot-border">
                                <h4>作り方</h4>
                                <table class="table table-responsive table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="col-1">順番</th>
                                            <th class="col-4">手順</th>
                                            <th class="col-6">詳細</th>
                                            <th class="col-1"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <!-- 登録済みの手順データ -->
                                    @foreach ($processes as $index => $process)
                                        @if(isset($process->process) || isset($process->detail))
                                            <tr class="process">
                                                <td class="col-1">{{$index +1}}</td>
                                                <td class="col-4"><input type="text" class="form-control" id="process-{{ $index }}" name="process-{{$index}}" value="{{ old('process-' . $index, $process->process) }}"></td>
                                                <td class="col-6"><textarea class="form-control" id="detail-{{ $index }}" name="detail-{{$index}}">{{ old('detail-' . $index, $process->detail) }}</textarea></td>
                                                <td class="col-1"><button type="button" class="btn clearProcessBtn" data-id="{{ $index }}">×</button></td>
                                            </tr>
                                        @endif
                                    @endforeach

                                    <!-- 新規登録の手順フォーム -->
                                    @for ($i = $processes->count() + 1; $i <= 8; $i++)
                                        <tr class="process" style="display:none;">
                                            <td class="col-1">{{$i}}</td>
                                            <td class="col-4"><input type="text" class="form-control" id="process-{{ $i }}" name="process-{{ $i }}" id="process-{{ $i }}" value="{{ old('process-'. $i ) }}"></td>
                                            <td class="col-6"><textarea class="form-control" id="detail-{{ $i }}" name="detail-{{ $i }}">{{ old('detail-'. $i ) }}</textarea></td>
                                            <td class="col-1"><button type="button" class="btn clearProcessBtn" data-id="{{ $i }}">×</button></td>
                                        </tr>
                                    @endfor
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-success add-Btn" id="addProcessBtn">工程を追加</button>                                      
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary col-8 col-sm-6 m-auto">更新</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="scroll-btn-area">
                <button onclick="scrollToBottom()" class="btn btn-scroll top"><img src="{{ asset('img/arrow-down-circle.svg') }}" alt="画面下へスクロールするアイコン"></button>
                <button onclick="scrollToTop()" class="btn btn-scroll bottom"><img src="{{ asset('img/arrow-up-circle.svg') }}" alt="画面上へスクロールするアイコン"></button>
                <p class="m-0 text-center">スクロールボタン</p>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
<script src="{{ asset('js/recipe.js') }}"></script>
@stop
