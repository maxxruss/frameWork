function renderAllGoods() {
    var str = "getAllGoods=" + '1';
    $.ajax({
        url: '../controllers/Admin.php', // путь к php-обработчику
        type: 'POST', // метод передачи данных
        dataType: 'json', // тип ожидаемых данных в ответе
        data: str, // данные, которые передаем на сервер
        error: function (req, text, error) { // отслеживание ошибок во время выполнения ajax-запроса
            alert('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
        },
        success: function (dateAnswer) {
            console.log(dateAnswer);
            var table = '<table class="table table-hover"><thead><tr><th scope="col">Наименование</th><th scope="col">Количество</th><th scope="col">Сумма</th></tr></thead><tbody >';
            var i = 0;
            for (var key in dateAnswer) {
                table += '<tr class="rowGoods' + dateAnswer[key].id + '">';
                table += '<th>' + dateAnswer[key].nameFull + '</th>';
                table += '<td><i class="fas fa-plus addToBasket" onclick="addToBasket(' + dateAnswer[key].id + ')" data-id=' + dateAnswer[key].id + '></i>';
                table += '<div class="basketOneCount' + dateAnswer[key].id + '">' + dateAnswer[key].count + '</div>';
                table += '<i class="fas fa-minus deleteToBasket" onclick="deleteToBasket(' + dateAnswer[key].id + ')" data-id=' + dateAnswer[key].id + '></i></td>';
                table += '<td><div class="basketOneSum' + dateAnswer[key].id + '">' + dateAnswer[key].count * dateAnswer[key].price + '</div></td></tr>';
                i++;
            }
            table += $('</table>');
            var modal = $('.modal-body');
            modal.empty();
            modal.append(table);
        }
    });
};

function renderBasket() {
    var str = "getAllGoods=" + '1';
    $.ajax({
        url: '../controllers/Ajax/renderBasket', // путь к php-обработчику
        type: 'POST', // метод передачи данных
        dataType: 'json', // тип ожидаемых данных в ответе
        data: str, // данные, которые передаем на сервер
        error: function (req, text, error) { // отслеживание ошибок во время выполнения ajax-запроса
            alert('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
        },
        success: function (dateAnswer) {
            console.log(dateAnswer);
            var basketInfo = '<strong>Корзина</strong><br>';
            if (dateAnswer) {
                basketInfo += '<strong>' + dateAnswer + '</strong>';
            } else {
                basketInfo += '<strong>товаров нет(</strong>';

            }

            var showCountGoods = $('.showCountGoods');
            showCountGoods.empty();
            showCountGoods.append(basketInfo);
        }
    });
};


function renderBasketModal() {
    var str = "getBasketGoods=" + '1';
    $.ajax({
        url: '/controllers/Ajax/renderBasketModal', // путь к php-обработчику
        type: 'POST', // метод передачи данных
        dataType: 'json', // тип ожидаемых данных в ответе
        data: str, // данные, которые передаем на сервер
        error: function (req, text, error) { // отслеживание ошибок во время выполнения ajax-запроса
            alert('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
        },
        success: function (dateAnswer) {
            console.log(dateAnswer);
            var sumGood = 0;
            var table = '<table class="table table-hover"><thead><tr><th scope="col">Наименование</th><th scope="col">Количество</th><th scope="col">Сумма</th></tr></thead><tbody >';
            for (var key in dateAnswer) {
                sumGood += dateAnswer[key].count * dateAnswer[key].price;
                table += '<tr class="rowGoods' + dateAnswer[key].id + '">';
                table += '<th>' + dateAnswer[key].nameFull + '</th>';
                table += '<td><div class="countModal"><div class="simbolModal"><i class="fas fa-plus" onclick="addToBasket(' + dateAnswer[key].id + ')" data-id=' + dateAnswer[key].id + '></i></div>';
                table += '<div class="basketOneCount' + dateAnswer[key].id + '">' + dateAnswer[key].count + '</div>';
                table += '<div class="simbolModal"><i class="fas fa-minus" onclick="deleteToBasket(' + dateAnswer[key].id + ')" data-id=' + dateAnswer[key].id + '></i></div></div></td>';
                table += '<td><div class="basketOneSum' + dateAnswer[key].id + '">' + dateAnswer[key].count * dateAnswer[key].price + '</div></td></tr>';
            }
            ;
            table += '<tr class="">';
            table += '<td></td><th>Сумма заказа</th>';
            table += '<td><div class="bascketTotalSum">' + sumGood + '</div></td></tr>';
            table += ('</table>');
            var modal = $('.modal-body');
            modal.empty();
            modal.append(table);
        }
    });
};

function renderItemModal(idGood) {
    var str = "renderItemModal=" + idGood;
    $.ajax({
        url: '/controllers/Ajax/renderItemModal', // путь к php-обработчику
        type: 'POST', // метод передачи данных
        dataType: 'json', // тип ожидаемых данных в ответе
        data: str, // данные, которые передаем на сервер
        error: function (req, text, error) { // отслеживание ошибок во время выполнения ajax-запроса
            alert('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
        },
        success: function (dateAnswer) {
            var table = '<div class="goodsWrapItem">';
            table += '<div class="wrapGoodImgItem">';
            table += '<img class="goodImg" src=' + dateAnswer.bigPhoto + '>';
            table += '</div>';
            table += '<div class="wrapGoodInfo">';
            table += '<div class="goodsNameFull">' + dateAnswer.nameFull + '</div>';
            table += '<div class="goodsPriceItem">' + dateAnswer.price + '<b>&#8381;</b></div>';
            table += '<div class="goodsParam"><span><b>Состав: </b></span>' + dateAnswer.param + '</div>';
            table += '<div class="goodsWeightItem"><span><b>Вес: </b></span>' + dateAnswer.weight + 'гр./порцию</div>';

            if (dateAnswer.discount > 0) {
                table += '<div class="stickerItem"><img class="stickerImgItem" src="/public/css/star.png"><span class="stickerTextItem">' + dateAnswer.discount + '%</span><div class="explain">блюдо со скидкой дня' + dateAnswer.discount + '%</div></div>';
            }

            if (dateAnswer.stickerFit === 1) {
                table += '<div class="stickerItem"><img class="stickerImgItem" src="/public/css/star.png"><span class="stickerTextItem">Fit!</span><div class="explain">блюдо с низкой калорийностью</div></div></div>';
            }

            if (dateAnswer.stickerHit === 1) {
                table += '<div class="stickerItem"><img class="stickerImgItem" src="/public/css/star.png"><span class="stickerTextItem">Hit!</span><div class="explain">популярное блюдо</div></div></div>';
            }

            table += '<div class="btnWrapItem"></div></div>';

            table += '</table>';
            var modal = $('.item_modal');
            modal.empty();
            modal.append(table);
        }
});
}







function addToBasket(idGood) {
    var str = "addBasketid=" + idGood;
    $.ajax({
        url: '/controllers/Ajax/addToBasket', // путь к php-обработчику
        type: 'POST', // метод передачи данных
        dataType: 'json', // тип ожидаемых данных в ответе
        data: str, // данные, которые передаем на сервер
        error: function (req, text, error) { // отслеживание ошибок во время выполнения ajax-запроса
            alert('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
        },
        success: function (dateAnswer) {
            if (dateAnswer) {
                console.log(dateAnswer);
                $('.basketInfoOut').html('<strong>Корзина</strong>' + '<br>' + '<strong>' + dateAnswer[0] + '</strong>');
                $('.basketOneCount' + idGood).html(dateAnswer[2]);
                $('.basketOneSum' + idGood).html(dateAnswer[3]);
                $('.bascketTotalSum').html(dateAnswer[4]);
                renderBasket();
            }
        }
    });
};

function deleteToBasket(idGood) {
    var str = "deleteToBasketid=" + idGood;
    $.ajax({
        url: '/controllers/Ajax/deleteToBasket', // путь к php-обработчику
        type: 'POST', // метод передачи данных
        dataType: 'json', // тип ожидаемых данных в ответе
        data: str, // данные, которые передаем на сервер
        error: function (req, text, error) { // отслеживание ошибок во время выполнения ajax-запроса
            alert('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
        },
        success: function (dateAnswer) {
            console.log(dateAnswer);
            if (dateAnswer[2] > 0) {
                $('.basketInfoOut').html('<strong>Корзина</strong>' + '<br>' + '<strong>' + dateAnswer[0] + '</strong>');
                $('.basketOneCount' + idGood).html(dateAnswer[2]);
                $('.basketOneSum' + idGood).html(dateAnswer[3]);
                $('.bascketTotalSum').html(dateAnswer[4]);
            } else if (dateAnswer[0] == null) {
                console.log(dateAnswer[0]);
                $('.basketInfoOut').html('<strong>Корзина</strong>' + '<br>' + '<strong>товаров нет(</strong>');
                renderBasketModal();
            } else {
                renderBasketModal();
            }
            renderBasket();
        }
    });
};

function renderAdminAjax() {
    var str = "renderAdminAjax=" + '1';
    $.ajax({
        url: '../controllers/Ajax/renderAdminAjax', // путь к php-обработчику
        type: 'POST', // метод передачи данных
        dataType: 'json', // тип ожидаемых данных в ответе
        data: str, // данные, которые передаем на сервер
        error: function (req, text, error) { // отслеживание ошибок во время выполнения ajax-запроса
            alert('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
        },
        success: function (dateAnswer) {
            var table = '<div class="headTable"><div class="headerCell id">Id</div><div class="headerCell nameFull">Hаименование</div><div class="headerCell price">Цена</div><div class="headerCell param">Состав</div><div class="headerCell weight">Вес</div><div class="headerCell discount">скидка</div><div class="headerCell loadFile">Загрузить фото</div><div class="headerCell stickerAdmin">Fit</div><div class="headerCell stickerAdmin">Hit</div><div class="headerCell views">просмотры</div><div class="headerCell operation">Операции</div></div>';
            for (var key in dateAnswer) {
                table += '<form class="formAdmin" id="form' + dateAnswer[key].id + '" onsubmit="editGood(' + dateAnswer[key].id + ')" action="javascript:void(null);" method="POST" enctype="multipart/form-data">';
                table += '<div class="rowCell  id" name="id">' + dateAnswer[key].id + '</div>';
                table += '<input type="hidden" name="id" value="' + dateAnswer[key].id + '">';
                table += '<input type="hidden" name="edit" value="1">';
                table += '<input type="text" name="nameFull" class="rowCell nameFull" value="' + dateAnswer[key].nameFull + '">';
                table += '<input type="text" name="price" class="rowCell price" value="' + dateAnswer[key].price + '">';
                table += '<textarea type="text" name="param" class="rowCell param">' + dateAnswer[key].param + '</textarea>';
                table += '<input type="text" name="weight" class="rowCell weight" value=' + dateAnswer[key].weight + '>';
                table += '<input type="text" name="discount" class="rowCell discount" value=' + dateAnswer[key].discount + '>';
                table += '<input class="rowCell loadFile" type="file" id="userfile" name="userfile" class="rowCell  loadFile">';
                if (dateAnswer[key].stickerFit == 1) {
                    table += '<div class="rowCell stickerAdmin"><input type="checkbox" name="stickerFit" checked ></div>';
                } else {
                    table += '<div class="rowCell stickerAdmin"><input type="checkbox" name="stickerFit"></div>';
                }
                ;
                if (dateAnswer[key].stickerHit == 1) {
                    table += '<div class="rowCell stickerAdmin"><input type="checkbox" name="stickerHit"  checked></div>';
                } else {
                    table += '<div class="rowCell stickerAdmin"><input type="checkbox" name="stickerHit"></div>';
                }
                ;
                table += '<div class="rowCell views">' + dateAnswer[key].views + '</div>';
                table += '<input class="btnAdmin" type="submit" value="Сохранить"><button class="btnAdmin" onclick="deleteGood(' + dateAnswer[key].id + ')" >Удалить</button></form>';
            }
            var tableGoodsAdmin = $('.mainTable');
            tableGoodsAdmin.empty();
            tableGoodsAdmin.append(table);
        }
    });
}

function addNewGood() {
    //preventDefault(); // делаем отмену действия браузера и формируем ajax
    var str = "addNewGood=" + 1;

    // данные с формы завернем в переменную для ajax
    $.ajax({
        type: 'POST', // тип запроса
        url: '../controllers/Ajax/addNewGood', // куда будем отправлять, можно явно указать
        data: str, // данные, которые передаем
        success: function (data) { // в случае успешного завершения
            console.log("Завершилось успешно"); // выведем в консоли успех
            console.log(data); // выведем в консоли успех
            renderAdminAjax();
        },
        error: function (data) { // в случае провала
            console.log("Завершилось с ошибкой"); // сообщение об ошибке
            console.log(data); // и данные по ошибке в том числе
        }
    });
};

function scanDirLoadFiles() {
    //preventDefault(); // делаем отмену действия браузера и формируем ajax
    var str = "scanDirLoadFiles=" + 1;
    // данные с формы завернем в переменную для ajax
    $.ajax({
        type: 'POST', // тип запроса
        url: '../controllers/Ajax/scanDirLoadFiles', // куда будем отправлять, можно явно указать
        data: str, // данные, которые передаем
        success: function (data) { // в случае успешного завершения
            console.log("Завершилось успешно"); // выведем в консоли успех
            console.log(data); // выведем в консоли успех
            renderAdminAjax();
            setTimeout(function () {
                //alert('ok');
                $("#scanDirLoadFiles").modal("hide")
            });
        },
        error: function (data) { // в случае провала
            console.log("Завершилось с ошибкой"); // сообщение об ошибке
            console.log(data); // и данные по ошибке в том числе
        }
    });
};


function editGood(idGood) {
    //preventDefault(); // делаем отмену действия браузера и формируем ajax
    //var formData = $('#form'+idGood).serialize();
    var formData = new FormData($('#form' + idGood)[0]);
    console.log(formData);
    // данные с формы завернем в переменную для ajax
    $.ajax({
        type: 'POST', // тип запроса
        url: '../controllers/Ajax/editGood', // куда будем отправлять, можно явно указать
        data: formData, // данные, которые передаем
        cache: false, // кэш и прочие настройки писать именно так (для файлов)
        // (связано это с кодировкой и всякой лабудой)
        contentType: false, // нужно указать тип контента false для картинки(файла)
        processData: false, // для передачи картинки(файла) нужно false
        success: function (data) { // в случае успешного завершения
            console.log("Завершилось успешно"); // выведем в консоли успех
            console.log(data); // выведем в консоли успех
            renderAdminAjax();
        },
        error: function (data) { // в случае провала
            console.log("Завершилось с ошибкой"); // сообщение об ошибке
            console.log(data); // и данные по ошибке в том числе
        }
    });

};

function deleteGood(id) {
    var str = "deleteGoodid=" + id;
    $.ajax({
        url: '../controllers/Ajax/deleteGood', // путь к php-обработчику
        type: 'POST', // метод передачи данных
        dataType: 'json', // тип ожидаемых данных в ответе
        data: str, // данные, которые передаем на сервер
        error: function (req, text, error) { // отслеживание ошибок во время выполнения ajax-запроса
            alert('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
        },
        success: function (dateAnswer) {
            renderAdminAjax();
        }
    });
};

function dbCreateOrder() {
    var str = "dbCreateOrder=" + 1;
    $.ajax({
        url: '../controllers/Ajax/dbCreateOrder', // путь к php-обработчику
        type: 'POST', // метод передачи данных
        dataType: 'json', // тип ожидаемых данных в ответе
        data: str, // данные, которые передаем на сервер
        error: function (req, text, error) { // отслеживание ошибок во время выполнения ajax-запроса
            alert('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
        },
        success: function (dateAnswer) {
            console.log(dateAnswer);
        }
    });
};


function renderOrder() {
    var str = "renderOrder=" + '1';
    $.ajax({
        url: '../controllers/Ajax/renderOrder', // путь к php-обработчику
        type: 'POST', // метод передачи данных
        dataType: 'json', // тип ожидаемых данных в ответе
        data: str, // данные, которые передаем на сервер
        error: function (req, text, error) { // отслеживание ошибок во время выполнения ajax-запроса
            alert('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
        },
        success: function (dateAnswer) {
            var sumGood = 0;
            var sumGoodDiscount = 0;
            var happyHoursDiscount;
            var delivery;


            for (var key in dateAnswer) {
                sumGood += dateAnswer[key].count * dateAnswer[key].price;
                if (dateAnswer[key].discount > 0) {
                    sumGoodDiscount += dateAnswer[key].count * dateAnswer[key].price * ((100 - dateAnswer[key].discount) / 100);
                } else {
                    sumGoodDiscount += dateAnswer[key].count * dateAnswer[key].price;
                }
            }

                var date = new Date(dateAnswer[0].timeOrder * 1000);// Hours part from the timestamp
                var hours = date.getHours();// Minutes part from the timestamp
                var minutes = "0" + date.getMinutes();// Seconds part from the timestamp
                var formattedTime = hours + ':' + minutes.substr(-2);// Will display time in 10:30:23 format

                if (hours >= 0 && hours <= 7) {
                    happyHoursDiscount = sumGoodDiscount * 7 / 100;
                } else {
                    happyHoursDiscount = 0;
                }



                if (dateAnswer[0].delivery == 0) {
                    delivery = 0;
                } else {
                    delivery = sumGoodDiscount * 10 / 100;
                }

            var totalCoast = Math.floor(sumGoodDiscount - happyHoursDiscount - delivery);

            var table = '<table class="table table-hover table-bordered"><thead><tr><th scope="col">Наименование</th><th scope="col">Количество</th><th scope="col">Цена</th><th scope="col">Сумма</th><th scope="col">Скидка</th><th scope="col">Сумма c учетом скидки</th></tr></thead><tbody >';
            for (var key in dateAnswer) {
                table += '<tr class="rowGoods' + dateAnswer[key].id + '">';
                table += '<td>' + dateAnswer[key].nameFull + '</td>';
                table += '<td><div class="countModal"><div class="simbolModal"><i class="fas fa-plus" onclick="addToOrder(' + dateAnswer[key].id + ')" data-id=' + dateAnswer[key].id + '></i></div>';
                table += '<div class="basketOneCount' + dateAnswer[key].id + '">' + dateAnswer[key].count + '</div>';
                table += '<div class="simbolModal"><i class="fas fa-minus" onclick="deleteToOrder(' + dateAnswer[key].id + ')" data-id=' + dateAnswer[key].id + '></i></div></div></td>';
                table += '<td>' + dateAnswer[key].price + '</td>';
                table += '<td>' + dateAnswer[key].count * dateAnswer[key].price + '</td>';
                table += '<td>' + dateAnswer[key].discount + ' %</td>';

                if (dateAnswer[key].discount > 0) {
                    var goodDiscount = dateAnswer[key].count * dateAnswer[key].price * ((100 - dateAnswer[key].discount) / 100);
                } else {
                    var goodDiscount = dateAnswer[key].count * dateAnswer[key].price;
                }

                table += '<td>' + Math.floor(goodDiscount) + '</td></tr>';
            }





            table += '<tr><th colspan="5">Итого</th>';
            table += '<th>' + totalCoast + '</th></tr>';
            table += ('</table>');

            var modal = $('.orderModalBody');
            modal.empty();
            modal.append(table);
            var orderTable = $('.orderTable');
            orderTable.empty();
            if (dateAnswer.length == 0) {
                $(orderTable).text('В корзине пусто!');
            } else {
                orderTable.append(table);
            }
        }
    });
};

function addToOrder(idGood) {
    var str = "addBasketid=" + idGood;
    $.ajax({
        url: '/controllers/Ajax/addToBasket', // путь к php-обработчику
        type: 'POST', // метод передачи данных
        dataType: 'json', // тип ожидаемых данных в ответе
        data: str, // данные, которые передаем на сервер
        error: function (req, text, error) { // отслеживание ошибок во время выполнения ajax-запроса
            alert('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
        },
        success: function (dateAnswer) {
                renderOrder();
                renderBasket();
        }
    });
}

function deleteToOrder(idGood) {
    var str = "deleteToBasketid=" + idGood;
    $.ajax({
        url: '/controllers/Ajax/deleteToBasket', // путь к php-обработчику
        type: 'POST', // метод передачи данных
        dataType: 'json', // тип ожидаемых данных в ответе
        data: str, // данные, которые передаем на сервер
        error: function (req, text, error) { // отслеживание ошибок во время выполнения ajax-запроса
            alert('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
        },
        success: function (dateAnswer) {
            renderOrder();
            renderBasket();
        }
    });
}


function deliveryCheck(mark) {
    var str = "deliveryCheck=" + mark;
    $.ajax({
        url: '../controllers/Ajax/deliveryCheck', // путь к php-обработчику
        type: 'POST', // метод передачи данных
        dataType: 'json', // тип ожидаемых данных в ответе
        data: str, // данные, которые передаем на сервер
        error: function (req, text, error) { // отслеживание ошибок во время выполнения ajax-запроса
            alert('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
        },
        success: function (dateAnswer) {
            renderOrder();
        }
    });
}

/**function sendOrder() {
    var formData = $('.formOrder').serialize();
    console.log(formData);
    $.ajax({
        url: '../controllers/Basket.php', // путь к php-обработчику
        type: 'POST', // метод передачи данных
        dataType: 'json', // тип ожидаемых данных в ответе
        //cache: false, // кэш и прочие настройки писать именно так (для файлов)
        // (связано это с кодировкой и всякой лабудой)
        //contentType: false, // нужно указать тип контента false для картинки(файла)
        //processData: false, // для передачи картинки(файла) нужно false
        data: formData, // данные, которые передаем на сервер
        error: function (req, text, error) { // отслеживание ошибок во время выполнения ajax-запроса
            alert('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
        },
        success: function (dateAnswer) {
            console.log(dateAnswer);
            $(location).attr('href', 'orderEnd.php');
        }
    });
};*/


function renderManager() {
    var str = "renderManager=" + '1';
    $.ajax({
        url: '../controllers/Ajax/renderManager', // путь к php-обработчику
        type: 'POST', // метод передачи данных
        dataType: 'json', // тип ожидаемых данных в ответе
        data: str, // данные, которые передаем на сервер
        error: function (req, text, error) { // отслеживание ошибок во время выполнения ajax-запроса
            alert('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
        },
        success: function (dateAnswer) {
            //console.log(dateAnswer);

            var table = '<table class="table table-hover table-bordered"><thead><tr><th scope="col">#</th><th scope="col">Заказ</th><th scope="col">Время заказа</th><th scope="col">Сдача с купюры</th><th scope="col">Способ оплаты</th><th scope="col">Доставка/самовывоз</th><th scope="col">Заказ на время</th><th scope="col">Телефон</th><th scope="col">Дисконтная карта</th><th scope="col">Персон</th><th scope="col">Адрес</th><th scope="col">Комментарий</th><th scope="col">Закрыть заказ</th></tr></thead><tbody>';

            for (var key in dateAnswer) {
                if (dateAnswer[key].inWork == 1) {


                var date = new Date(dateAnswer[key].timeOrder * 1000);// Hours part from the timestamp
                var hours = date.getHours();// Minutes part from the timestamp
                var minutes = "0" + date.getMinutes();// Seconds part from the timestamp
                var formattedTime = hours + ':' + minutes.substr(-2);// Will display time in 10:30:23 format

                table += '<tr><th scope="row">' + dateAnswer[key].id + '</th>';
                table += '<td><button type="button" onclick="orderDetails(' + dateAnswer[key].id+ ')" class="btn btn-primary" data-toggle="modal" data-target="#orderModal">Детали заказа</button></td>';
                table += '<td>' + formattedTime + '</td>';
                table += '<td>' + dateAnswer[key].money + '</td>';

                if (dateAnswer[key].pay == 1) {
                    table += '<td>Безнал</td>';
                } else {
                    table += '<td>Нал</td>';
                }

                if (dateAnswer[key].delivery == 1) {
                    table += '<td>Доставка</td>';
                } else {
                    table += '<td>Самовывоз</td>';
                }

                table += '<td>' + dateAnswer[key].desiredTime + '</td>';
                table += '<td>' + dateAnswer[key].phone + '</td>';
                table += '<td>' + dateAnswer[key].discountCard + '</td>';
                table += '<td>' + dateAnswer[key].persons + '</td>';
                table += '<td>' + dateAnswer[key].address + '</td>';
                table += '<td>' + dateAnswer[key].comment + '</td>';
                table += '<td><button type="button" onclick="completeOrder(' + dateAnswer[key].id+ ')" class="btn btn-primary" data-toggle="modal" data-target="#completeOrder">Выполнено!</button></td></tr>';
                }
            }

            table += ('</tbody></table>');
            var mainTableManager = $('.mainTableManager');
            mainTableManager.empty();
            mainTableManager.append(table);
        }
    });
}

function orderDetails(orderId) {
    var str = "orderDetails=" + orderId;
    $.ajax({
        url: '../controllers/Ajax/orderDetails', // путь к php-обработчику
        type: 'POST', // метод передачи данных
        dataType: 'json', // тип ожидаемых данных в ответе
        data: str, // данные, которые передаем на сервер
        error: function (req, text, error) { // отслеживание ошибок во время выполнения ajax-запроса
            alert('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
        },
        success: function (dateAnswer) {
            console.log(dateAnswer);

            var sumGood = 0;
            var sumGoodDiscount = 0;
            var happyHoursDiscount;
            var delivery;
            for (var key in dateAnswer) {
                sumGood += dateAnswer[key].count * dateAnswer[key].price;
                if (dateAnswer[key].discount > 0) {
                    sumGoodDiscount += dateAnswer[key].count * dateAnswer[key].price * ((100 - dateAnswer[key].discount) / 100);
                } else {
                    sumGoodDiscount += dateAnswer[key].count * dateAnswer[key].price;
                }
                ;
            }
            ;

            var date = new Date(dateAnswer[0].timeOrder * 1000);// Hours part from the timestamp
            var hours = date.getHours();// Minutes part from the timestamp
            var minutes = "0" + date.getMinutes();// Seconds part from the timestamp
            var formattedTime = hours + ':' + minutes.substr(-2);// Will display time in 10:30:23 format

            if (hours >= 0 && hours <= 7) {
                happyHoursDiscount = sumGoodDiscount * 7 / 100;
            } else {
                happyHoursDiscount = 0;
            }
            ;

            if (dateAnswer[key].delivery == 0) {
                delivery = 0;
            } else {
                delivery = sumGoodDiscount * 10 / 100;
            }
            ;

            var totalCoast = Math.floor(sumGoodDiscount - happyHoursDiscount - delivery);

            var table = '<table class="table table-hover table-bordered"><thead><tr><th scope="col">Наименование</th><th scope="col">Количество</th><th scope="col">Цена</th><th scope="col">Сумма</th><th scope="col">Скидка</th><th scope="col">Сумма c учетом скидки</th></tr></thead><tbody >';
            for (var key in dateAnswer) {
                table += '<tr class="rowGoods' + dateAnswer[key].id + '">';
                table += '<td>' + dateAnswer[key].nameFull + '</td>';
                table += '<td>' + dateAnswer[key].count + '</td>';
                table += '<td>' + dateAnswer[key].price + '</td>';
                table += '<td>' + dateAnswer[key].count * dateAnswer[key].price + '</td>';
                table += '<td>' + dateAnswer[key].discount + ' %</td>';

                if (dateAnswer[key].discount > 0) {
                    var goodDiscount = dateAnswer[key].count * dateAnswer[key].price * ((100 - dateAnswer[key].discount) / 100);
                } else {
                    var goodDiscount = dateAnswer[key].count * dateAnswer[key].price;
                }
                ;
                table += '<td>' + Math.floor(goodDiscount) + '</td></tr>';
            }
            ;

            table += '<tr><th>Итого</th><th>-</th><th>-</th>';
            table += '<th>' + Math.floor(sumGood) + '</th><th>-</th>';
            table += '<th>' + Math.floor(sumGoodDiscount) + '</th></tr>';
            table += '<tr><th colspan="5">Скидка "Счастливый час (-7% за заказ с 00:00 до 08:00)"</th>';
            table += '<th>-' + Math.floor(happyHoursDiscount) + '</th></tr>';
            table += '<tr><th colspan="5">Скидка за самовывоз (10%)</th>';
            table += '<th>-' + Math.floor(delivery) + '</th></tr>';
            table += '<tr><th colspan="5">Сумма к оплате</th>';
            table += '<th>' + totalCoast + '</th></tr>';
            table += ('</table>');
            var modal = $('.orderModalBody');
            modal.empty();
            modal.append(table);
        }
    });
};

function renderOrderEnd() {
    var str = "orderEnd=" + '1';
    $.ajax({
        url: '../controllers/Ajax/orderEnd', // путь к php-обработчику
        type: 'POST', // метод передачи данных
        dataType: 'json', // тип ожидаемых данных в ответе
        data: str, // данные, которые передаем на сервер
        error: function (req, text, error) { // отслеживание ошибок во время выполнения ajax-запроса
            alert('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
        },
        success: function (dateAnswer) {

            var sumGood = 0;
            var sumGoodDiscount = 0;
            var happyHoursDiscount;
            var delivery;


            for (var key in dateAnswer) {
                sumGood += dateAnswer[key].count * dateAnswer[key].price;
                if (dateAnswer[key].discount > 0) {
                    sumGoodDiscount += dateAnswer[key].count * dateAnswer[key].price * ((100 - dateAnswer[key].discount) / 100);
                } else {
                    sumGoodDiscount += dateAnswer[key].count * dateAnswer[key].price;
                }
            }


            var date = new Date(dateAnswer[0].timeOrder * 1000);// Hours part from the timestamp
            var hours = date.getHours();// Minutes part from the timestamp
            var minutes = "0" + date.getMinutes();// Seconds part from the timestamp
            var formattedTime = hours + ':' + minutes.substr(-2);// Will display time in 10:30:23 format

            if (hours >= 0 && hours <= 7) {
                happyHoursDiscount = sumGoodDiscount * 7 / 100;
            } else {
                happyHoursDiscount = 0;
            }
            ;

            if (dateAnswer[0].delivery == 0) {
                delivery = 0;
            } else {
                delivery = sumGoodDiscount * 10 / 100;
            }
            ;

            var totalCoast = Math.floor(sumGoodDiscount - happyHoursDiscount - delivery);

            var table = '<table class="table table-hover table-bordered"><thead><tr><th scope="col">Наименование</th><th scope="col">Цена</th><th scope="col">Сумма</th><th scope="col">Скидка</th><th scope="col">Сумма c учетом скидки</th></tr></thead><tbody >';
            for (var key in dateAnswer) {
                table += '<tr class="rowGoods' + dateAnswer[key].id + '">';
                table += '<tr><td>' + dateAnswer[key].nameFull + '</td>';
                table += '<td>' + dateAnswer[key].price + '</td>';
                table += '<td>' + dateAnswer[key].count * dateAnswer[key].price + '</td>';
                table += '<td>' + dateAnswer[key].discount + ' %</td>';

                if (dateAnswer[key].discount > 0) {
                    var goodDiscount = dateAnswer[key].count * dateAnswer[key].price * ((100 - dateAnswer[key].discount) / 100);
                } else {
                    var goodDiscount = dateAnswer[key].count * dateAnswer[key].price;
                }

                table += '<td>' + Math.floor(goodDiscount) + '</td></tr>';

            }


            table += '<tr><th  colspan="4">Итого</th>';
            table += '<th>' + Math.floor(sumGoodDiscount) + '</th></tr>';
            table += '<tr><th colspan="4">Скидка "Счастливый час" (Заказ был сделан в ' + formattedTime + ')</th>';
            table += '<th>-' + Math.floor(happyHoursDiscount) + '</th></tr>';
            table += '<tr><th colspan="4">Скидка за самовывоз</th>';
            table += '<th>-' + Math.floor(delivery) + '</th></tr>';
            table += '<tr><th colspan="4">Сумма к оплате</th>';
            table += '<th>' + totalCoast + '</th></tr>';
            table += ('</table>');

            // table += '<tr><th colspan="1">Сумма к оплате с учетом всех скидок</th>';
            // table += '<th>' + totalCoast + ' &#8381;</th></tr>';
            //
            // table += '<tr><th colspan="1">Доставка</th>';
            //
            // if (dateAnswer[key].delivery == 0) {
            //     table += '<th>Доставка по адресу заказчика</th></tr>';
            // } else {
            //     table += '<th>Самовывоз</th></tr>';
            // }
            // ;
            // table += ('</table>');
            table += '<div class="thanks">Ваша экономия - ' + Math.floor(sumGood-totalCoast) + '&#8381;<br>Ваш заказ поступил в обработку!<br> В ближайшее время с Вами свяжется менеджер для подтверждения и уточнения заказа.<br> Спасибо что выбрали нас!</div>';

            var orderTableEnd = $('.orderTableEnd');
            orderTableEnd.empty();
            orderTableEnd.append(table);
        }
    });
};

