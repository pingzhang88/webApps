/*** function that will create the request object ***/
  function createRequestObj()
  {
     var req = null;
     if (window.XMLHttpRequest) 
     {
        req = new XMLHttpRequest();
     } 
     else if (window.ActiveXObject) 
     {
        try 
        {
           req = new ActiveXObject("Msxml2.XMLHTTP");
        } 
        catch (othermicrosoft) 
        {
           try 
           {
              req = new ActiveXObject("Microsoft.XMLHTTP");
           } 
           catch (failed) 
           {
              req = null;
           }
       }
    }

    return req;
  }
