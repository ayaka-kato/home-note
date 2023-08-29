@extends('adminlte::page')

@section('title', 'レシピ登録')

@section('content_header')
    <h1>レシピ登録</h1>
@stop

@section('content')
    <div class="row" id="create-recipe">
        <div class="col-12 col-md-10">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card card-primary" id="create-recipe">
                <form method="POST" action="{{ route('storeRecipe') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="form-group col-12 col-md-8 col-xl-6">
                            <label for="name">レシピ名<span class="need-mark">必須</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="（例）肉じゃが" value="{{ old('name') }}" autofocus>
                        </div>

                        <div class="form-group col-10 col-md-8">
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
                                            <label for="type-8" class="mr-2"><input type="radio" name="category" id="type-8" value="副菜(きのこ)" {{ old('type') == "副菜(きのこ)" ? "checked": null}}>副菜(きのこ)</label>
                                            <label for="type-9" class="mr-2"><input type="radio" name="category" id="type-9" value="副菜(海藻)" {{ old('type') == "副菜(海藻)" ? "checked": null}}>副菜(海藻)</label>
                                            <label for="type-10" class="mr-2"><input type="radio" name="category" id="type-10" value="副菜(その他)" {{ old('type') == "副菜(その他)" ? "checked": null}}>副菜(その他)</label>
                                            <label for="type-11" class="mr-2"><input type="radio" name="category" id="type-11" value="スープ" {{ old('type') == "スープ" ? "checked": null}}>スープ</label>
                                            <label for="type-12" class="mr-2"><input type="radio" name="category" id="type-12" value="デザート" {{ old('type') == "デザート" ? "checked": null}}>デザート</label>
                                            <label for="type-13" class="mr-2"><input type="radio" name="category" id="type-13" value="その他" {{ old('type') == "その他" ? "checked": null}}>その他</label>
                                        </div>
                                        <p class="error-msg">{{ $errors->first('text') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-12 col-md-10">
                            <b>材料</b>
                            <div class="d-flex" id="ingredient-table">
                                <div class="form-group col-12  col-sm-8 col-md-3">
                                    <label for="serving" class="font-normal">何人前</label>
                                    <input type="text" class="form-control" id="serving" name="serving" placeholder="（例）2人前" value="{{ old('serving')}}">                                            
                                </div>
                                <div class="form-group col-12 col-md-9" >                                
                                    <table class="table table-responsive table-hover text-nowrap" id="amount-table">
                                        <thead>
                                            <tr>
                                                <th class="col-6 col-md-6 font-normal">名前</th>
                                                <th class="col-6 col-md-6 font-normal">分量</th>
                                            </tr>
                                        </thead>
                                        <tbody>                                 
                                            @for($i = 0; $i < 20; $i++)
                                                <!-- 初期表示 -->
                                                @if($i < 5)
                                                <tr class="ingredient">                                            
                                                    <td class="col-6 col-md-4"><input type="text" class="form-control" name="ingredient-{{ $i }}" placeholder="（例）人参" value="{{ old('ingredient-' . $i ) }}"></td>
                                                    <td class="col-6 col-md-4"><input type="text" class="form-control" name="amount-{{ $i }}" placeholder="（例）1/2本" value="{{ old('amount-' . $i) }}"></td>
                                                </tr>
                                                <!-- 追加ボタン押下で表示 -->
                                                @else
                                                <tr class="ingredient" style="display:none;">   
                                                    <td class="col-6 col-md-4"><input type="text" class="form-control" name="ingredient-{{ $i }}" placeholder="（例）人参" value="{{ old('ingredient' . $i) }}"></td>
                                                    <td class="col-6 col-md-4"><input type="text" class="form-control" name="amount-{{ $i }}" placeholder="（例）1/2本" value="{{ old('amount-' . $i) }}"></td>
                                                </tr>
                                                @endif
                                            @endfor
                                        </tbody>
                                    </table>
                                    <button type="button" id="addIngredientBtn" class="btn btn-success">食材を追加</button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group  col-12 col-md-8">
                            <label for="link">参考リンク</label>
                            <input type="text" class="form-control" id="link" name="link" placeholder="（例）https//..." value="{{ old('link') }}">
                        </div>

                        <div class="form-group col-12 col-md-8">
                            <label for="image">画像</label>
                            <div id="previewImage" class="border"></div>
                            <input type="file" class="form-control" id="image" name="image" value="{{ old('image') }}">
                        </div>

                        <div class="col-12 dot-border">
                            <b>作り方</b>
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="col-1 col-md-1 font-normal">順番</th>
                                        <th class="col-4 col-md-4 font-normal">工程</th>
                                        <th class="col-6 col-md-6 font-normal">詳細</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 0; $i < 8; $i++)
                                        @if($i < 4)
                                        <tr class="process">
                                            <td class="col-1 col-md-1">{{$i+1}}</td>
                                            <td class="col-4 col-md-4"><input type="text" class="form-control" name="process-{{ $i }}" value="{{ old('process-'. $i ) }}"></td>
                                            <td class="col-6 col-md-6"><textarea class="form-control" name="detail-{{ $i }}">{{ old('detail-'. $i ) }}</textarea></td>
                                        </tr>
                                        @else
                                        <tr class="process" style="display:none;">
                                            <td class="col-1 col-md-1">{{$i+1}}</td>
                                            <td class="col-4 col-md-4"><input type="text" class="form-control" name="process-{{ $i }}" value="{{ old('process-'. $i ) }}"></td>
                                            <td class="col-6 col-md-6"><textarea class="form-control" name="detail-{{ $i }}">{{ old('detail-'. $i ) }}</textarea></td>
                                        </tr>
                                        @endif
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-success add-Btn" id="addProcessBtn">手順を追加</button>
                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary col-8 col-sm-6 m-auto">登録</button>
                    </div>
                </form>
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
