var Produto = {

    desastivar: function(codigo)
    {
        var elem = document.getElementById('produto-' + codigo);
        if (elem != undefined) {

        }
    }
};

var Ajax = function(options)
{
    var self = this;

    function init()
    {
        self.options = options;
        try {
            self.xhr = new XMLHttpRequest();
            self.xhr.upload.onprogress = function (evt)
            {
                if (evt.lengthComputable && typeof(self.options.progress) == "function") {
                    var percent = evt.loaded / evt.total * 100;
                    self.options.progress(percent);
                }
            };

            self.xhr.onreadystatechange = function()
            {
                if (self.xhr.status == 200 && self.xhr.readyState == 4) {
                    try {
                        if (typeof(self.options.success) == "function") {
                            var response = self.xhr.responseText;
                            self.options.success(JSON.parse(response));
                        }
                    } catch (ex) {
                        console.error("ERRO - " + ex);
                    }
                }
            };

            self.xhr.onerror = function(evt)
            {
                if (typeof(self.options.error) == "function") {
                    self.options.error(evt);
                }
            }
        } catch (ex) {
            console.error(ex);
        }
    }

    self.send = function(data)
    {
        self.xhr.open("POST", self.options.url, true);
        self.xhr.send(data);
        return true;
    };

    self.setOnProgressListener = function(callback)
    {
        if (typeof(callback) != 'function')
            throw new Error('Invalid callback');

        self.options.progress = callback;
    };

    self.setOnSuccessListener = function(callback)
    {
        if (typeof(callback) != 'function')
            throw new Error('Invalid callback');

        self.options.success = callback;
    };

    self.setOnErrorListener = function(callback)
    {
        if (typeof(callback) != 'function')
            throw new Error('Invalid callback');

        self.options.error = callback;
    };

    self.getOptions = function()
    {
        return self.options;
    };

    init(); // Instancia os objetos
};