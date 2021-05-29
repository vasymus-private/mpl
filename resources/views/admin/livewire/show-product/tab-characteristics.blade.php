<h3><button class="btn btn-warning">&uarr;</button> <button class="btn btn-warning">&darr;</button> Описание товара <button class="btn btn-danger">x</button></h3>
<div class="form-group row">
    <label for="t" class="col-sm-2 col-form-label">Высота:</label>
    <div class="col-sm-2">
        <button class="btn btn-warning">&uarr;</button> <button class="btn btn-warning">&darr;</button>
    </div>
    <div class="col-sm-1">
        <button class="btn btn-danger">x</button>
    </div>
    <div class="col-sm-7">
        <input type="text" class="form-control" id="t">
    </div>
</div>
<div class="form-group row">
    <label for="d" class="col-sm-2 col-form-label">Цвет:</label>
    <div class="col-sm-2">
        <button class="btn btn-warning">&uarr;</button> <button class="btn btn-warning">&darr;</button>
    </div>
    <div class="col-sm-1">
        <button class="btn btn-danger">x</button>
    </div>
    <div class="col-sm-7">
        <input type="text" class="form-control" id="d">
    </div>
</div>

<h3><button class="btn btn-warning">&uarr;</button> <button class="btn btn-warning">&darr;</button> Технические детали <button class="btn btn-danger">x</button></h3>
<div class="form-group row">
    <label for="t1" class="col-sm-3 col-form-label">Твердость:</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="t1">
    </div>
</div>
<div class="form-group row">
    <label for="gd" class="col-sm-3 col-form-label">Хрупкость:</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="gd">
    </div>
</div>

<button type="button" class="btn btn-success" data-toggle="modal" data-target="#staticBackdrop">+ Добавить характеристику</button>
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#staticBackdrop2">+ Добавить заголовок для характеристик</button>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Выбрать заголовок характеристики:</label>
                    <div class="col-sm-9">
                        <select class="form-control">
                            <option value="">(не установлено)</option>
                            <option value="">Описание товара</option>
                            <option value="">Технические детали</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tl" class="col-sm-3 col-form-label">Название характерстики:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="tl">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Тип поля ввода:</label>
                    <div class="col-sm-9">
                        <select class="form-control" >
                            <option value="">Текстовое</option>
                            <option value="">Рейтинг</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary">Создать</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="staticBackdrop2" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="tl" class="col-sm-3 col-form-label">Название заголовка:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="tl">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary">Создать</button>
            </div>
        </div>
    </div>
</div>
