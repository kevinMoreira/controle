var Ajax = function(method, url, asynchronous) {
    this.method = method;
    this.url = url;
    this.asynchronous = asynchronous;
    this.funcao = '';

    this.setURL = function(url) {
        this.url = url;
    }

    this.OnReadyStateChange = function(callback) {
        this.ajax.onreadystatechange = callback;
    }

    this.CreateObject = function() {
        var xmlHttp = null;

        try {
            xmlHttp = new XMLHttpRequest();
        }
        catch (e)
        {
            try {
                xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
            }
            catch (e)
            {
                try {
                    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                catch (e) {
                    xmlHttp = null;
                }
            }
        }

        return xmlHttp;
    }

    this.ajax = this.CreateObject();

    this.isStateOK = function() {
        if (this.ajax.readyState == 4 && this.ajax.status == 200)
            return true;
        else
            return false;
    }

    this.Request = function(params) {
        switch (this.method.toUpperCase())
        {
            case 'POST':
                this.ajax.open(this.method, this.url, this.asynchronous);
                this.ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                this.ajax.send(params);
                break;

            case 'GET':
                this.ajax.open(this.method, this.url + '?' + params, this.asynchronous);
                this.ajax.send(null);
                break;
        }
    }

    this.getResponseText = function() {
        return this.ajax.responseText;
    }

    this.getResponseXML = function() {
        return this.ajax.responseXML;
    }

    this.Finalize = function() {
        this.ajax = null;
    }

    this.returnOK = function() {
        if (this.ajax.readyState == 4 && this.ajax.status == 200)
            return true;
        else
            return false;
    }
}

var DOM = {
    newText: function(text) {
        return document.createTextNode(text);
    },
    newElement: function(type, id) {
        var obj = null;
        if (type == 'text' || type == 'password' || type == 'radio' || type == 'checkbox' || type == 'file' || type == 'form.button' || type == 'image' || type == 'submit') {
            obj = document.createElement('input');
            obj.setAttribute('type', type.replace('form.', ''));
        } else {
            obj = document.createElement(type);
        }
        if(id)
            obj.setAttribute('id',id);
        
        return obj;
    }
}

function getParameter(name){

	var p = window.location.search;

        if (p == '')
            return null;

        var array = p.substr(1).split('&');

        for (var i = 0; i < array.length; i++) {
            var arrayItem = array[i].split('=');

            if (arrayItem[0] == name)
                return arrayItem[1];
        }

        return null;
}

var Mask = {
    setNull: function(obj) {
        obj.maxLength = 60;
        obj.onkeypress = function(ev) {

        }
    },
    setCelular: function(obj) {
        obj.maxLength = 15;
        obj.onkeypress = function(ev) {
            ev = window.event || ev;
            var keyCode = ev.keyCode || ev.which;


            if (keyCode === 9 || keyCode === 46 || keyCode === 8)
                return true;

            if (!Number.isNumber(String.fromCharCode(keyCode)))
                return false;

            var temp = obj.value;

            if (temp.length == 0)
            {
                temp += '(';
                obj.value = temp;
                return true;
            }

            if (temp.length == 3)
            {
                temp += ') ';
                obj.value = temp;
                return true;
            }

            if (temp.length == 4)
            {
                temp += ' ';
                obj.value = temp;
                return true;
            }

            if (temp.length >= 4) {
                if (temp.substring(0, 4) == '(11)') {
                    if (temp.length == 10)
                    {
                        obj.maxLength = 15;
                        temp += '-';
                        obj.value = temp;
                        return true;
                    }
                }
                else {
                    if (temp.length == 9)
                    {
                        obj.maxLength = 14;
                        temp += '-';
                        obj.value = temp;
                        return true;
                    }
                }
            }
        }
    },
    setTelefone: function(obj) {
        obj.maxLength = 14;
        obj.onkeypress = function(ev) {
            ev = window.event || ev;
            var keyCode = ev.keyCode || ev.which;

            if (keyCode === 9 || keyCode === 46 || keyCode === 8)
                return true;

            if (!Number.isNumber(String.fromCharCode(keyCode)))
                return false;

            var temp = obj.value;

            if (temp.length == 0)
            {
                temp += '(';
                obj.value = temp;
                return true;
            }

            if (temp.length == 3)
            {
                temp += ') ';
                obj.value = temp;
                return true;
            }

            if (temp.length == 4)
            {
                temp += ' ';
                obj.value = temp;
                return true;
            }

            if (temp.length == 9)
            {
                temp += '-';
                obj.value = temp;
                return true;
            }
        }
    },
    setCEP: function(obj) {
        obj.maxLength = 9;
        obj.onkeypress = function(ev) {
            ev = window.event || ev;
            var keyCode = ev.keyCode || ev.which;

            if (keyCode === 9 || keyCode === 46 || keyCode === 8)
                return true;

            if (!Number.isNumber(String.fromCharCode(keyCode)))
                return false;

            var temp = obj.value;

            if (temp.length == 5) {
                temp += '-';
                obj.value = temp;
                return;
            }
        }
    },
    setCNPJ: function(obj) {
        obj.maxLength = 18;
        obj.onkeypress = function(ev) {
            ev = window.event || ev;
            var keyCode = ev.keyCode || ev.which;

            if (keyCode === 9 || keyCode === 46 || keyCode === 8)
                return true;

            if (!Number.isNumber(String.fromCharCode(keyCode)))
                return false;

            var temp = obj.value;

            if (temp.length == 2)
            {
                temp += '.';
                obj.value = temp;
                return;
            }

            if (temp.length == 6)
            {
                temp += '.';
                obj.value = temp;
                return;
            }

            if (temp.length == 10)
            {
                temp += '/';
                obj.value = temp;
                return;
            }

            if (temp.length == 15)
            {
                temp += '-';
                obj.value = temp;
                return;
            }
        }
    },
    setCPF: function(obj) {
        obj.maxLength = 14;
        obj.onkeypress = function(ev) {
            ev = window.event || ev;
            var keyCode = ev.keyCode || ev.which;

            if (keyCode === 9 || keyCode === 46 || keyCode === 8)
                return true;

            if (!Number.isNumber(String.fromCharCode(keyCode)))
                return false;

            var temp = obj.value;

            if (temp.length == 3)
            {
                temp += '.';
                obj.value = temp;
                return;
            }

            if (temp.length == 7)
            {
                temp += '.';
                obj.value = temp;
                return;
            }

            if (temp.length == 11)
            {
                temp += '-';
                obj.value = temp;
                return;
            }
        }
    },
    setRG: function(obj) {
        obj.maxLength = 12;
        obj.onkeypress = function(ev) {
            ev = window.event || ev;
            var keyCode = ev.keyCode || ev.which;

            if (keyCode === 9 || keyCode === 46 || keyCode === 8)
                return true;

            if (!Number.isNumber(String.fromCharCode(keyCode)))
                return false;

            var temp = obj.value;

            if (temp.length === 2)
            {
                temp += '.';
                obj.value = temp;
                return;
            }

            if (temp.length === 6)
            {
                temp += '.';
                obj.value = temp;
                return;
            }

            if (temp.length === 10)
            {
                temp += '-';
                obj.value = temp;
                return;
            }
        }
    },
    setMesAno: function(obj) {
        obj.maxLength = 7;

        obj.onkeypress = function(ev) {
            ev = window.event || ev;
            var keyCode = ev.keyCode || ev.which;

            if (keyCode === 9 || keyCode === 46 || keyCode === 8)
                return true;

            if (!Number.isNumber(String.fromCharCode(keyCode)))
                return false;

            var mydata = obj.value;

            if (mydata.length == 2)
            {
                mydata += '/';
                obj.value = mydata;
                return;
            }
        }
    },
    setData: function(obj) {
        var temHora = false;

        if (arguments.length == 2)
            temHora = arguments[1];

        if (temHora)
            obj.maxLength = 16;
        else
            obj.maxLength = 10;

        obj.onblur = function() {
            this.value = Date.AjustaData(this.value);
        }

        obj.onkeypress = function(ev) {
            ev = window.event || ev;
            var keyCode = ev.keyCode || ev.which;

            if (keyCode === 9 || keyCode === 46 || keyCode === 8)
                return true;

            if (!Number.isNumber(String.fromCharCode(keyCode)))
                return false;

            var mydata = obj.value;

            if (mydata.length == 2)
            {
                mydata += '/';
                obj.value = mydata;
                return;
            }

            if (mydata.length == 5)
            {
                mydata += '/';
                obj.value = mydata;
                return;
            }

            if (temHora)
            {
                if (mydata.length == 10)
                {
                    mydata += ' ';
                    obj.value = mydata;
                    return;
                }
                if (mydata.length == 13)
                {
                    mydata += ':';
                    obj.value = mydata;
                    return;
                }
            }

        }
    },
    setHora: function(obj, withSeconds) {
        if (withSeconds)
            obj.maxLength = 8;
        else
            obj.maxLength = 5;

        obj.onkeypress = function(ev) {
            ev = window.event || ev;
            var keyCode = ev.keyCode || ev.which;

            if (keyCode === 9 || keyCode === 46 || keyCode === 8)
                return true;

            if (!Number.isNumber(String.fromCharCode(keyCode)))
                return false;
                       
            var temp = obj.value;           
            
            if (temp.length == 2) {                
                temp = temp + ':';                
                obj.value = temp;
                return;
            }

            if (withSeconds) {
                if (temp.length == 5) {
                    temp = temp + ':';
                    obj.value = temp;
                    return;
                }
            }
        };
    },
    setOnlyNumbers: function(obj) {
        obj.onkeypress = function(ev) {
            ev = window.event || ev;
            var keyCode = ev.keyCode || ev.which;

            if (keyCode === 9 || keyCode === 46 || keyCode === 8)
                return true;

            if (!Number.isNumber(String.fromCharCode(keyCode)))
                return false;

        }
    },
    setCurrency: function(obj) {
        obj.style.textAlign = 'right';
        obj.maxLength = 15;
        obj.onkeypress = function(ev) {
            ev = window.event || ev;
            var keyCode = ev.keyCode || ev.which;

            // permite a propaga??o do BACKSPACE mesmo
            // quando alcan?ado o tamanho m?ximo do texto
            if (keyCode !== 8)
                if (obj.value.length >= obj.maxLength)
                    return false;

            // libera as teclas BACKSPACE e TAB
            if (keyCode === 8 || keyCode === 9)
                return true;

            if (!Number.isNumber(String.fromCharCode(keyCode)))
                return false;

            var temp = Number.Filter(obj.value) + String.fromCharCode(keyCode);

            switch (temp.length) {
                /*case 0:
                 obj.value = ',  ';
                 break;
                 
                 case 1:
                 obj.value = ', ' + temp;
                 break;
                 
                 case 2:
                 obj.value = ',' + temp;
                 break;*/

                default:
                    temp = temp.substr(0, temp.length - 2) + ',' + temp.substr(temp.length - 2, temp.length - 1);
                    alert(temp);
                    obj.value = Number.FormatMoeda(temp);
                    break;
            }

        }
    },
    setMoeda: function(obj) {
        obj.style.textAlign = 'right';
        obj.maxLength = 15;
        obj.value = ',  ';
        obj.onkeypress = function(ev) {
            ev = window.event || ev;
            var keyCode = ev.keyCode || ev.which;

            // permite a propaga??o do BACKSPACE mesmo
            // quando alcan?ado o tamanho m?ximo do texto
            if (keyCode !== 8)
                if (obj.value.length >= obj.maxLength)
                    return false;

            // libera as teclas BACKSPACE e TAB
            if (keyCode === 8 || keyCode === 9)
                return true;

            if (!Number.isNumber(String.fromCharCode(keyCode)))
                return false;

            var temp = Number.Filter(obj.value) + String.fromCharCode(keyCode);

            switch (temp.length)
            {
                case 0:
                    obj.value = ',  ';
                    break;

                case 1:
                    obj.value = ', ' + temp;
                    break;

                case 2:
                    obj.value = ',' + temp;
                    break;

                default:
                    temp = temp.substr(0, temp.length - 2) + ',' + temp.substr(temp.length - 2, temp.length - 1);
                    obj.value = temp;
                    break;
            }

            return false;
        }

        obj.onfocus = function() {
            if (Number.getFloat(this.value) === 0.0)
                this.value = ',  ';
        }

        obj.onkeydown = function(ev) {
            ev = window.event || ev;
            var keyCode = ev.keyCode || ev.which;

            if (keyCode != 8)
                return true;

            this.value = this.value.substr(0, this.value.length - 1);
            var temp = Number.Filter(this.value);

            switch (temp.length)
            {
                case 0:
                    this.value = ',  ';
                    break;

                case 1:
                    this.value = ', ' + temp;
                    break;

                case 2:
                    this.value = ',' + temp;
                    break;

                default:
                    temp = temp.substr(0, temp.length - 2) + ',' + temp.substr(temp.length - 2, 2);
                    this.value = temp;
                    break;
            }

            return false;
        }
    }
}

Table = function(id) {
    this.table = document.createElement('table');
    this.thead = document.createElement('thead');
    this.tbody = document.createElement('tbody');
    this.tfoot = document.createElement('tfoot');

    this.table.setAttribute('id', id);

    this.table.appendChild(this.thead);
    this.table.appendChild(this.tbody);
    this.table.appendChild(this.tfoot);

    this.rowData = new Array();

    // adiciona cabe?alho
    this.addHeader = function(thArray) {
        var tr = document.createElement('tr');

        for (var i = 0; i < thArray.length; i++) {
            var th = document.createElement('th');
            th.appendChild(thArray[i]);
            tr.appendChild(th);
        }

        this.thead.appendChild(tr);
    }

    // adiciona linha
    this.addRow = function(tdArray) {
        var tr = document.createElement('tr');

        for (var i = 0; i < tdArray.length; i++) {
            var td = document.createElement('td');
            td.appendChild(tdArray[i]);
            tr.appendChild(td);
        }

        this.tbody.appendChild(tr);
        this.rowData.push(0);
    }

    // adiciona rodap?
    this.addFooter = function(tdArray) {
        var tr = document.createElement('tr');

        for (var i = 0; i < tdArray.length; i++) {
            var td = document.createElement('td');
            td.appendChild(tdArray[i]);
            tr.appendChild(td);
        }

        this.tfoot.appendChild(tr);
    }

    // obt?m linhas da tabela
    this.getRow = function(rowNumber) {
        return this.tbody.childNodes[rowNumber];
    }

    // obt?m quantidade de linhas da tabela
    this.getRowCount = function() {
        return this.tbody.childNodes.length;
    }
    // obt?m numero de colunas de uma linha
    this.getColCount = function(rowNumber) {
        return this.tbody.childNodes[rowNumber].childNodes.length;
    }

    // obt?m uma c?clula da tabela
    this.getCell = function(rowNumber, colNumber) {
        return this.getRow(rowNumber).childNodes[colNumber];
    }

    //OBTEM A CELULA DO CABEÇALHO, PODE-SE OCULTAR A CELULA E ETC.
    this.getHeadCell = function(colNumber) {
        return this.thead.childNodes[0].childNodes[colNumber];
    }

    this.getHeadText = function(colNumber) {
        return this.thead.childNodes[0].childNodes[colNumber].childNodes[0].data;
    }

    // obt?m o valor (texto) de uma c?lula da tabela
    this.getCellText = function(rowNumber, colNumber) {
        return this.getCell(rowNumber, colNumber).childNodes[0].data;
    }

    // obt?m o objeto dentro de uma c?lula
    this.getCellObject = function(rowNumber, colNumber) {
        return this.getCell(rowNumber, colNumber).childNodes[0];
    }

    // obt?m o valor da linha
    this.getRowData = function(rowNumber) {
        return this.rowData[rowNumber];
    }

    // define o valor da linha
    this.setRowData = function(rowNumber, value) {
        return this.rowData[rowNumber] = value;
    }

    // exclui uma linha
    this.deleteRow = function(rowNumber) {
        //alert(rowNumber);
        this.tbody.removeChild(this.getRow(rowNumber));
        this.rowData.splice(rowNumber, 1);
    }

    // define o texto de uma c?lula
    this.setCellText = function(rowNumber, colNumber, value) {
        this.getCell(rowNumber, colNumber).childNodes[0].data = value;
    }

    this.setHeadText = function(colNumber, value) {
        this.thead.childNodes[0].childNodes[colNumber].childNodes[0].data = value;
    }

    this.setHeadValue = function(colNumber, value) {
        this.thead.childNodes[0].childNodes[colNumber].childNodes[0].rowData = value;
    }

    this.setCellObject = function(rowNumber, colNumber, value) {
        if (this.getCell(rowNumber, colNumber).childNodes.length > 0)
            this.getCell(rowNumber, colNumber).removeChild(this.getCellObject(rowNumber, colNumber));

        this.getCell(rowNumber, colNumber).appendChild(value);
    }

    // limpa a tabela
    this.clearRows = function() {
        for (var i = this.getRowCount() - 1; i >= 0; i--)
            this.deleteRow(i);
    }

    // obt?m o n?mero de c?lulas selecionadas (checkbox)
    this.getSelCount = function(col) {
        var count = 0;

        for (var i = 0; i < this.getRowCount(); i++) {
            if (this.getCellObject(i, col).checked)
                count++;
        }

        return count;
    }

    // obt?m o n?mero das linhas selecionadas
    this.getSelectedRows = function(col) {
        var count = Array();

        for (var i = 0; i < this.getRowCount(); i++) {
            if (this.getCellObject(i, col).checked)
                count.push(i);
        }

        return count;
    }

    // obt?m o n?mero das linhas selecionadas
    this.getRowDataSelectedRows = function(col) {
        var count = Array();

        for (var i = 0; i < this.getRowCount(); i++) {
            if (this.getCellObject(i, col).checked)
                count.push(this.getRowData(i));
        }

        return count;
    }

    this.addColGroup = function(span, styles) {
        var colgroup = document.createElement('colgroup');
        colgroup.span = span;

        //  if (styles <> '') {
        //  colgroup.style.visibility = ;
        //}

        this.thead.appendChild(colgroup);
    }

    //soma o valor da tabela de determinada coluna
    this.SumCol = function(col) {
        var valorTotal = 0;

        for (var i = 0; i < this.getRowCount(); i++) {
            valorTotal += Number.getFloat(this.getCellText(i, col).toString().replace('.', ''));
        }

        return valorTotal.toFixed(2);
    }

    //soma o valor da tabela de determinada coluna que esteja selecionada (checked)
    this.SumColChecked = function(col) {
        var valorTotal = 0;

        for (var i = 0; i < this.getRowCount(); i++) {
            if (this.getCellObject(i, 0).checked) {
                valorTotal += Number.getFloat(this.getCellText(i, col).toString().replace('.', ''));
            }

        }

        return valorTotal.toFixed(2);
    }

    this.setRowForegroundColor = function(row, color) {
        this.getRow(row).style.color = color;
    }

    this.setRowBackgroundColor = function(row, color) {
        if (row < 0)
            return;

        for (var col = 0; col < this.getRow(row).childNodes.length; col++)
        {
            this.getCell(row, col).style.backgroundColor = color;
        }
    }
}