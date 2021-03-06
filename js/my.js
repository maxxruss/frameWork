function renderBasket() {
    var str = "getAllGoods=" + '1';
    $.ajax({
        url: '../controllers/Ajax/renderBasket', // путь к php-обработчику
        type: 'POST', // метод передачи данных
        dataType: 'json', // тип ожидаемых данных в ответе
        data: str, // данные, которые передаем на сервер
        error: function (req, text, error) { // отслеживание ошибок во время выполнения ajax-запроса
            alert('Хьюстон, У нас проблемы! c рендер баскет ' + text + ' | ' + error);
        },
        success: function (dateAnswer) {
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
}

function renderBasketModal() {
    var str = "getBasketGoods=" + '1';
    $.ajax({
        url: '/controllers/Ajax/renderBasketModal',
        type: 'POST',
        dataType: 'json',
        data: str,
        error: function (req, text, error) {
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
                table += '<td><div class="countModal"><div class="simbolModal"><i class="fas fa-plus" onclick="addToBasketModal(' + dateAnswer[key].id + ')" data-id=' + dateAnswer[key].id + '></i></div>';
                table += '<div class="basketOneCount' + dateAnswer[key].id + '">' + dateAnswer[key].count + '</div>';
                table += '<div class="simbolModal"><i class="fas fa-minus" onclick="deleteToBasketModal(' + dateAnswer[key].id + ')" data-id=' + dateAnswer[key].id + '></i></div></div></td>';
                table += '<td><div class="basketOneSum' + dateAnswer[key].id + '">' + dateAnswer[key].count * dateAnswer[key].price + '</div></td></tr>';
            }
            table += '<tr class="">';
            table += '<td></td><th>Сумма заказа</th>';
            table += '<td><div class="bascketTotalSum">' + sumGood + '</div></td></tr>';
            table += ('</table>');
            var modal = $('.modal-body');
            modal.empty();
            modal.append(table);
        }
    });
}

function renderItemModal(idGood) {
    var str = "renderItemModal=" + idGood;
    $.ajax({
        url: '/controllers/Ajax/renderItemModal',
        type: 'POST',
        dataType: 'json',
        data: str,
        error: function (req, text, error) {
            alert('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
        },
        success: function (dateAnswer) {
            var table = '<div class="goodsWrapItem">';
            table += '<div class="wrapGoodImgItem">';
            table += '<img class="goodImg" src=/public/' + dateAnswer.bigPhoto + '>';
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

            var footer = '<div class="modal_footer__button_wrap">';
            footer += '<div class="btnWrap"><input type="button" class="addToBasket btn" value="Дoбавить в корзину" onclick="addToBasket(' + dateAnswer.id + ')">';
            footer += '<input type="button" class="deleteToBasket btn" value="Удалить из корзины" onclick="deleteToBasket(' + dateAnswer.id + ')"></div>';
            footer += '<button type="button" class="btn btn-secondary" data-dismiss="modal">Продолжить покупки</button>';
            footer += '</div>';

            var modal = $('.item_modal');
            var modalFooter = $('.item_footer');

            modal.empty();
            modal.append(table);

            modalFooter.empty();
            modalFooter.append(footer);
        }
    });
}

function addToBasket(idGood) {
    var str = "addBasketid=" + idGood;
    $.ajax({
        url: '/controllers/Ajax/addToBasket',
        type: 'POST',
        dataType: '',
        data: str,
        error: function (req, text, error) {
            alert('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
        },
        success: function (dateAnswer) {
            renderBasket();
        }
    });
}

function addToBasketModal(idGood) {
    var str = "addBasketid=" + idGood;
    $.ajax({
        url: '/controllers/Ajax/addToBasket',
        type: 'POST',
        dataType: '',
        data: str,
        error: function (req, text, error) {
            alert('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
        },
        success: function (dateAnswer) {
            renderBasketModal();
            renderBasket();
        }
    });
}

function deleteToBasket(idGood) {
    var str = "deleteToBasketid=" + idGood;
    $.ajax({
        url: '/controllers/Ajax/deleteToBasket',
        type: 'POST',
        dataType: '',
        data: str,
        error: function (req, text, error) {
            alert('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
        },
        success: function () {
            renderBasket();
        }
    });
}

function deleteToBasketModal(idGood) {
    var str = "deleteToBasketid=" + idGood;
    $.ajax({
        url: '/controllers/Ajax/deleteToBasket',
        type: 'POST',
        dataType: '',
        data: str,
        error: function (req, text, error) {
            alert('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
        },
        success: function () {
            renderBasketModal();
            renderBasket();
        }
    });
}

function renderAdminAjax() {
    var str = "renderAdminAjax=" + '1';
    $.ajax({
        url: '../controllers/Ajax/renderAdminAjax',
        type: 'POST',
        dataType: 'json',
        data: str,
        error: function (req, text, error) {
            alert('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
        },
        success: function (dateAnswer) {
            var table = '<div class="headTable"><div class="headerCell id">Id</div><div class="headerCell nameFull">Hаименование</div><div class="headerCell price">Цена</div><div class="headerCell param">Состав</div><div class="headerCell weight">Вес</div><div class="headerCell discount">скидка</div><div class="headerCell loadFile">Загрузить фото</div><div class="headerCell stickerAdmin">Fit</div><div class="headerCell stickerAdmin">Hit</div><div class="headerCell operation">Операции</div></div>';
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
    $.ajax({
        type: 'POST',
        url: '../controllers/Ajax/addNewGood',
        data: str,
        success: function (data) {
            console.log("Завершилось успешно");
            console.log(data);
            renderAdminAjax();
        },
        error: function (data) {
            console.log("Завершилось с ошибкой");
            console.log(data);
        }
    });
}

function scanDirLoadFiles() {
    var str = "scanDirLoadFiles=" + 1;
    $.ajax({
        type: 'POST', // тип запроса
        url: '../controllers/Ajax/scanDirLoadFiles',
        data: str,
        success: function (data) {
            console.log("Завершилось успешно");
            console.log(data);
            renderAdminAjax();
            setTimeout(function () {
                //alert('ok');
                $("#scanDirLoadFiles").modal("hide")
            });
        },
        error: function (data) {
            console.log("Завершилось с ошибкой");
            console.log(data);
        }
    });
}


function editGood(idGood) {
    var formData = new FormData($('#form' + idGood)[0]);
    console.log(formData);
    $.ajax({
        type: 'POST',
        url: '../controllers/Ajax/editGood',
        data: formData,
        cache: false,
        // (связано это с кодировкой и всякой лабудой)
        contentType: false, // нужно указать тип контента false для картинки(файла)
        processData: false, // для передачи картинки(файла) нужно false
        success: function (data) {
            console.log("Завершилось успешно");
            console.log(data);
            renderAdminAjax();
        },
        error: function (data) {
            console.log("Завершилось с ошибкой");
            console.log(data);
        }
    });

}

function deleteGood(id) {
    var str = "deleteGoodid=" + id;
    $.ajax({
        url: '../controllers/Ajax/deleteGood',
        type: 'POST',
        dataType: 'json',
        data: str,
        error: function (req, text, error) {
            alert('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
        },
        success: function (dateAnswer) {
            renderAdminAjax();
        }
    });
}

// function dbCreateOrder() {
//     var str = "dbCreateOrder=" + 1;
//     $.ajax({
//         url: '../controllers/Ajax/dbCreateOrder',
//         type: 'POST',
//         dataType: 'json',
//         data: str,
//         error: function (req, text, error) {
//             alert('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
//         },
//         success: function (dateAnswer) {
//             console.log(dateAnswer);
//         }
//     });
// }

function renderOrder() {
    var str = "renderOrder=" + '1';
    $.ajax({
        url: '../controllers/Ajax/renderOrder',
        type: 'POST',
        dataType: 'json',
        data: str,
        error: function (req, text, error) {
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

            var table = '<div class="order__head"><div class="order__headName order__name">Наименование</div><div class="order__headCount order__count">Количество</div><div class="order__headPrice order__price">Цена</div><div class="order__headSum order__sum">Стоимость</div><div class="order__headDiscount order__discount">Скидка</div><div class="order__headPriceDiscount order__priceDiscount">Сумма</div></div>';
            for (var key in dateAnswer) {
                table += '<div class="order__goodsWrap">';
                table += '<div class="order__nameGood order__name">' + dateAnswer[key].nameFull + '</div>';
                table += '<div class="order__countGood order__count"><div class="simbolModal"><i class="fas fa-plus order__fa" onclick="addToOrder(' + dateAnswer[key].id + ')" data-id=' + dateAnswer[key].id + '></i></div>';
                table += '<div class="basketOneCount' + dateAnswer[key].id + ' ">' + dateAnswer[key].count + '</div>';
                table += '<div class="simbolModal"><i class="fas fa-minus order__fa" onclick="deleteToOrder(' + dateAnswer[key].id + ')" data-id=' + dateAnswer[key].id + '></i></div></div>';
                table += '<div class="order__priceGood order__price">' + dateAnswer[key].price + '</div>';
                table += '<div class="order__sumGood order__sum">' + dateAnswer[key].count * dateAnswer[key].price + '</div>';
                table += '<div class="order__discountGood order__discount">' + dateAnswer[key].discount + ' %</div>';

                if (dateAnswer[key].discount > 0) {
                    var goodDiscount = dateAnswer[key].count * dateAnswer[key].price * ((100 - dateAnswer[key].discount) / 100);
                } else {
                    var goodDiscount = dateAnswer[key].count * dateAnswer[key].price;
                }

                table += '<div class="order__sumDiscountGood order__priceDiscount">' + Math.floor(goodDiscount) + '</div></div>';
            }

            table += '</div></div>';
            table += '<div class="order__total"><div class="order__totalLable">Итого</div>';
            table += '<div class="order__totalValue">' + totalCoast + '</div></div>';

            var orderTable = $('.order__table');
            orderTable.empty();
            if (dateAnswer.length == 0) {
                console.log('пусто');
                $(orderTable).text('В корзине пусто!');
            } else {
                console.log('ok');

                orderTable.append(table);
            }
        }
    });
}

function renderOrderEnd() {
    var str = "orderEnd=" + '1';
    $.ajax({
        url: '../controllers/Ajax/orderEnd',
        type: 'POST',
        dataType: 'json',
        data: str,
        error: function (req, text, error) {
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

            var date = new Date(dateAnswer[0].timeOrder * 1000);
            var hours = date.getHours();
            var minutes = "0" + date.getMinutes();
            var formattedTime = hours + ':' + minutes.substr(-2);

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

            var table = '<div class="orderEnd__head"><div class="orderEnd__headName orderEnd__name">Наименование</div><div class="orderEnd__headPriceDiscount orderEnd__priceDiscount">Сумма</div></div>';

            for (var key in dateAnswer) {
                table += '<div class="orderEnd__goodsWrap orderEnd__itemWrap">';
                table += '<div class="orderEnd__nameGood orderEnd__name">' + dateAnswer[key].nameFull + '</div>';

                if (dateAnswer[key].discount > 0) {
                    var goodDiscount = dateAnswer[key].count * dateAnswer[key].price * ((100 - dateAnswer[key].discount) / 100);
                } else {
                    var goodDiscount = dateAnswer[key].count * dateAnswer[key].price;
                }

                table += '<div class="orderEnd__sumDiscountGood orderEnd__priceDiscount">' + Math.floor(goodDiscount) + '</div></div>';
            }

            table += '<div class="orderEnd__discountWrap orderEnd__itemWrap">';
            // table += '</div></div>';
            table += '<div class="orderEnd__discount">Скидка "Счастливый час" (Заказ был сделан в  ' + formattedTime + ')</div>';
            table += '<div class="orderEnd__discountValue">-' + Math.floor(happyHoursDiscount) + '</div></div>';
            table += '<div class="orderEnd__deliveryWrap orderEnd__itemWrap">';
            table += '<div class="orderEnd__delivery">Скидка за самовывоз</div>';
            table += '<div class="orderEnd__deliveryValue">-' + Math.floor(delivery) + '</div></div>';

            table += '<div class="orderEnd__total orderEnd__itemWrap">';
            table += '<div class="orderEnd__totalLable">Сумма к оплате</div>';
            table += '<div class="orderEnd__totalValue">' + totalCoast + '</div></div>';

            table += '<div class="orderEnd__thanks">Ваша экономия - ' + Math.floor(sumGood - totalCoast) + '&#8381;<br>Ваш заказ поступил в обработку!<br> В ближайшее время с Вами свяжется менеджер для подтверждения и уточнения заказа.<br> Спасибо что выбрали нас!</div>';

            var orderTableEnd = $('.orderEnd__table');
            orderTableEnd.empty();
            orderTableEnd.append(table);
        }
    });
}

function addToOrder(idGood) {
    var str = "addBasketid=" + idGood;
    $.ajax({
        url: '/controllers/Ajax/addToBasket',
        type: 'POST',
        dataType: 'json',
        data: str,
        error: function (req, text, error) {
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
        url: '/controllers/Ajax/deleteToBasket',
        type: 'POST',
        dataType: 'json',
        data: str,
        error: function (req, text, error) {
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
        url: '../controllers/Ajax/deliveryCheck',
        type: 'POST',
        dataType: 'json',
        data: str,
        error: function (req, text, error) {
            alert('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
        },
        success: function () {
            renderOrder();
        }
    });
}


function renderManager() {
    var str = "renderManager=" + '1';
    $.ajax({
        url: '../controllers/Ajax/renderManager',
        type: 'POST',
        dataType: 'json',
        data: str,
        error: function (req, text, error) {
            alert('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
        },
        success: function (dateAnswer) {
            var table = '<table class="table table-hover table-bordered"><thead><tr><th scope="col">#</th><th scope="col">Заказ</th><th scope="col">Время заказа</th><th scope="col">Сдача с купюры</th><th scope="col">Способ оплаты</th><th scope="col">Доставка/самовывоз</th><th scope="col">Заказ на время</th><th scope="col">Телефон</th><th scope="col">Дисконтная карта</th><th scope="col">Персон</th><th scope="col">Адрес</th><th scope="col">Комментарий</th><th scope="col">Закрыть заказ</th></tr></thead><tbody>';

            for (var key in dateAnswer) {
                if (dateAnswer[key].order_status == 1) {
                    var date = new Date(dateAnswer[key].timeOrder * 1000);
                    var hours = date.getHours();
                    var minutes = "0" + date.getMinutes();
                    var formattedTime = hours + ':' + minutes.substr(-2);

                    table += '<tr><th scope="row">' + dateAnswer[key].id + '</th>';
                    table += '<td><button type="button" onclick="orderDetails(' + dateAnswer[key].id + ')" class="btn btn-primary" data-toggle="modal" data-target="#orderModal">Детали заказа</button></td>';
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
                    table += '<td><button type="button" onclick="if(confirm(\'Изменить статус заказа на выполнено?\'))completeOrder(' + dateAnswer[key].id + ');else return false;" >Выполнено!</button></td></tr>';
                }
            }

            table += ('</tbody></table>');
            var mainTableManager = $('.mainTableManager');
            mainTableManager.empty();
            mainTableManager.append(table);
        }
    });
}

function completeOrder(order_id) {
    var str = "completeOrder=" + order_id;
    $.ajax({
        url: '../controllers/Ajax/completeOrder',
        type: 'POST',
        dataType: 'json',
        data: str,
        error: function (req, text, error) {
            alert('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
        },
        success: function (dateAnswer) {
            console.log(dateAnswer);
            renderManager();
        }
    });
}

function orderDetails(orderId) {
    var str = "orderDetails=" + orderId;
    $.ajax({
        url: '../controllers/Ajax/orderDetails',
        type: 'POST',
        dataType: 'json',
        data: str,
        error: function (req, text, error) {
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
            }

            var date = new Date(dateAnswer[0].timeOrder * 1000);
            var hours = date.getHours();
            var minutes = "0" + date.getMinutes();
            var formattedTime = hours + ':' + minutes.substr(-2);

            if (hours >= 0 && hours <= 7) {
                happyHoursDiscount = sumGoodDiscount * 7 / 100;
            } else {
                happyHoursDiscount = 0;
            }

            if (dateAnswer[key].delivery == 0) {
                delivery = 0;
            } else {
                delivery = sumGoodDiscount * 10 / 100;
            }

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
                table += '<td>' + Math.floor(goodDiscount) + '</td></tr>';
            }

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
}



