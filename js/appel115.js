/* Controle du bouton radio autre concernant les enfants */
function enfant(valeur)
{
	if(valeur=="5")
    {
        $('#autre_enfant').removeAttr('disabled');
        $('#autre_enfant').attr('required','required');
    }
    else
    {
        $('#autre_enfant').removeAttr('required');
        $('#autre_enfant').attr('disabled','disabled');
    }
}

/* Controle du bouton radio autre concernant les animaux */
function animaux(valeur)
{
    if(valeur=="1")
    {
        $('#autre_animal').removeAttr('disabled');
        $('#autre_animal').attr('required','required');
    }
    else
    {
        $('#autre_animal').removeAttr('required');
        $('#autre_animal').attr('disabled','disabled');
    }
}

/* Controle de la checkbox motif d'appel si clic sur prestation il y a apparition des prestations */
function prest(valeur)
{
    if(valeur=="5")
    {
		targetElement = document.getElementById('prestation');
        if(targetElement.style.display == "none")
        	targetElement.style.display = "" ;
        else
            targetElement.style.display = "none" ;
    }
}

function bebe(valeur)
{
	if(valeur=="1")
    {
        $('#mois1').removeAttr('disabled');
        $('#mois1').attr('required','required');

        $('#mois2').removeAttr('disabled');
        $('#mois2').attr('required','required');
    }
    else
    {
        if($('input[name=mois]:checked', '#mois1'))
			$('#mois1').attr('checked', false);
          
        if($('input[name=mois]:checked', '#mois2'))
        	$('#mois2').attr('checked', false);
          
        $('#mois1').removeAttr('required');
        $('#mois1').attr('disabled','disabled');

        $('#mois2').removeAttr('required');
        $('#mois2').attr('disabled','disabled');
    }
}

      /*function sexe1(valeur)
      {
        targetElement = document.getElementById('femmeEnceinte1');

        if(valeur=="femme")
        {
          if(targetElement.style.display == "none")
          {
            targetElement.style.display = "" ;
          } 
          else
          {
            targetElement.style.display = "none" ;
          }
        }
      }*/