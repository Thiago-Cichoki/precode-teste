goog.provide('precode.sistema.UtilService');

precode.sistema.UtilService = function () {
    var self = {
        dateToString,
        getTimeObject,
        setTimeObject,
        gerarFotoCidade,
        fixTimezone,
        cutString: function (str, length) {
            if (str.length > length) {
                return str.substring(0, 25) + '...';
            } else {
                return str;
            }
        },
        RESTENDPOINT: "/api",
        AUTHRESTENDPOINT: "/auth",
        POINT: "/web"
    };

    return self;

    function dateToString(d) {
        return moment(d).format('YYYY-MM-DD');
    }

    function getTimeObject(str) {
        if (str) {//https://stackoverflow.com/questions/34050389/remove-timezone-from-a-moment-js-object
            let s = "2017-06-01" + ' ' + str;
            let dt = new moment(s).utc().add(0, 'm').toDate();
            //var dt = new Date();
            //var h = str.substring(0, 2);
            //var m = str.substring(3, 5);
            //dt.setHours(h, m);
            return dt;
        } else {
            return null;
        }
    }

    function setTimeObject(dt) {
        let utc = new moment(dt);
        return new moment(dt).utc().add(utc.utcOffset(), 'm').toDate();
    }

    function fixTimezone(dt, mode) {
        if (angular.isUndefined(dt)) {
            dt = new Date();
        }
        //javascript adds timezone to date (-3hours to brazil), 
        //but we`re using literal time, so we add/remove 3hours
        if (mode === 'in') {//-0300 to +0100
            dt.setHours(dt.getHours());
        } else if (mode === 'out') {
            let utc = new moment(dt);
            dt = new moment(dt).utc().add(utc.utcOffset(), 'm').toDate();
        }

        return dt;
    }

    function gerarFotoCidade(cidade) {
        cidade = cidade.toLowerCase();
        switch (cidade) {
            case "contagem":
                return "https://live.staticflickr.com/65535/49778282861_a661ca300a_m.jpg";
                break;
            case "juiz de fora":
                return "https://live.staticflickr.com/65535/49777751078_8be1acc860_m.jpg";
                break;
            case "uberlândia":
                return "https://live.staticflickr.com/65535/49778282826_812233e1ce_m.jpg";
                break;
            case "campo grande":
                return "https://live.staticflickr.com/65535/49777751013_93b516682d_m.jpg";
                break;
            case "cuiabá":
                return "https://live.staticflickr.com/65535/49778613517_5f32611492_m.jpg";
                break;
            case "ananindeua":
                return "https://live.staticflickr.com/65535/49778613507_9327c4f7df_m.jpg";
                break;
            case "belém":
                return "https://live.staticflickr.com/65535/49777750963_6f7b2d2032_m.jpg";
                break;
            case "joão pessoa":
                return "https://live.staticflickr.com/65535/49778613477_7bf1e73e86_m.jpg";
                break;
            case "jaboatao dos guararapes":
                return "https://live.staticflickr.com/65535/49778613457_377444a6dd_m.jpg";
                break;
            case "recife":
                return "https://live.staticflickr.com/65535/49778613432_9f26676973_m.jpg";
                break;
            case "teresina":
                return "https://live.staticflickr.com/65535/49777750888_e41faec868_m.jpg";
                break;
            case "curitiba":
                return "https://live.staticflickr.com/65535/49777750868_889b25fd07_m.jpg";
                break;
            case "londrina":
                return "https://live.staticflickr.com/65535/49778282691_7d10bd2452_m.jpg";
                break;
            case "nova iguaçu":
                return "https://live.staticflickr.com/65535/49778282681_05cb2c6218_m.jpg";
                break;
            case "rio de janeiro":
                return "https://live.staticflickr.com/65535/49778282656_5869fb3df1_m.jpg";
                break;
            case "são gonçalo":
                return "https://live.staticflickr.com/65535/49778282666_232aa8a9c1_m.jpg";
                break;
            case "natal":
                return "https://live.staticflickr.com/65535/49778282641_ec1079545c_m.jpg";
                break;
            case "aracaju":
                return "https://live.staticflickr.com/65535/49778613247_50b4ceb9b3_m.jpg";
                break;
            case "campinas":
                return "https://live.staticflickr.com/65535/49778282561_1d30f166fe_m.jpg";
                break;
            case "osasco":
                return "https://live.staticflickr.com/65535/49778613197_68a8be3d11_m.jpg";
                break;
            case "ribeirão preto":
                return "https://live.staticflickr.com/65535/49778613187_afed2f5a27_m.jpg";
                break;
            case "santo andré":
                return "https://live.staticflickr.com/65535/49777750618_f5a50182c0_m.jpg";
                break;
            case "são bernardo do campo":
                return "https://live.staticflickr.com/65535/49778282471_800e6c7f78_m.jpg";
                break;
            case "são josé dos campos":
                return "https://live.staticflickr.com/65535/49777750573_4f4b0ec7d5_m.jpg";
                break;
            case "são paulo":
                return "https://live.staticflickr.com/65535/49778282361_1aa239f95a_m.jpg";
                break;
            case "sorocaba":
                return "https://live.staticflickr.com/65535/49778282351_43442ce733_m.jpg";
                break;
            case "maceió":
                return "https://live.staticflickr.com/65535/49778613042_096f798074_m.jpg";
                break;
            case "manaus":
                return "https://live.staticflickr.com/65535/49778282291_faf63e2546_m.jpg";
                break;
            case "feira de santana":
                return "https://live.staticflickr.com/65535/49778612932_17f5c0cdc3_m.jpg";
                break;
            case "salvador":
                return "https://live.staticflickr.com/65535/49778612892_eb2ec4bbfa_m.jpg";
                break;
            case "fortaleza":
                return "https://live.staticflickr.com/65535/49778282196_2559311036_m.jpg";
                break;
            case "aparecida de goiânia":
                return "https://live.staticflickr.com/65535/49778282166_74f45b76cb_m.jpg";
                break;
            case "são luís":
                return "https://live.staticflickr.com/65535/49778282161_b84cda3903_m.jpg";
                break;
            case "belo horizonte":
                return "https://live.staticflickr.com/65535/49778282106_bbe306c59c_m.jpg";
                break;
            case "macapa":
                return "https://live.staticflickr.com/65535/49778282106_bbe306c59c_m.jpg";
                break;
            case "serra":
                return "https://live.staticflickr.com/65535/49779452686_7fca64fd41_m.jpg";
                break;
            case "vila velha":
                return "https://live.staticflickr.com/65535/49779452666_f3742bdb95_m.jpg";
                break;
            case "betim":
                return "https://live.staticflickr.com/65535/49779784357_4f468f7f42_m.jpg";
                break;
            case "maringá":
                return "https://live.staticflickr.com/65535/49778920688_f0ee121949_m.jpg";
                break;
            case "campos dos goytacazes":
                return "https://live.staticflickr.com/65535/49779452606_c0e9a643fd_m.jpg";
                break;
            case "niterói":
                return "https://live.staticflickr.com/65535/49778920648_1d9d0c008e_m.jpg";
                break;
            case "são joão de mereti":
                return "https://live.staticflickr.com/65535/49779452561_783c99b282_m.jpg";
                break;
            case "porto velho":
                return "https://live.staticflickr.com/65535/49779784267_934a722111_m.jpg";
                break;
            case "caxias do sul":
                return "https://live.staticflickr.com/65535/49778920588_15a6a8b526_m.jpg";
                break;
            case "florianópolis":
                return "https://live.staticflickr.com/65535/49779452516_0ff3aa8f2b_m.jpg";
                break;
            case "diadema":
                return "https://live.staticflickr.com/65535/49779784202_c23b8a7b21_m.jpg";
                break;
            case "mogi das cruzes":
                return "https://live.staticflickr.com/65535/49779784182_20ca298482_m.jpg";
                break;
            case "santos":
                return "https://live.staticflickr.com/65535/49778920503_ca0be616da_m.jpg";
                break;
            case "são josé do rio preto":
                return "https://live.staticflickr.com/65535/49778920473_d001bdcc9f_m.jpg";
                break;
            case "porto alegre":
                return "https://live.staticflickr.com/65535/49778282616_eb5de79109_m.jpg";
                break;
            case "joinville":
                return "https://live.staticflickr.com/65535/49777750758_b6af3e3143_m.jpg";
                break;
        }
    }

}


