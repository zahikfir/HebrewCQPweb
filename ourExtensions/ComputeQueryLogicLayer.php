<script>

	var NumSupportSearchWord = 4;										// define for number of supported words
	var g_iCurrentWordIndex = 0; 										// indicate the word that the user is editing
	var g_aWordSearchArr = new Array(NumSupportSearchWord);   			// global arr size 4: cqp supports up to 4 words search
	var g_aMinWordsBetweenResults = new Array(NumSupportSearchWord-1); 	// min number of words between search results
	var g_aMaxWordsBetweenResults = new Array(NumSupportSearchWord-1);	// man number of words between search results 
	
	function ComputeQuery()
	{
		if( !(g_aMaxWordsBetweenResults && g_aMaxWordsBetweenResults && g_aWordSearchArr) )
			alert("Sorry Somthing Is wrong with ComputeQuery()");
		else
		{
			var myTextField = document.getElementById('QueryWordTextBox');
			var myTextField2 = document.getElementById('QueryTextbox');


			//g_aWordSearchArr[0] = "word=\"לפי\"";
			//g_aWordSearchArr[1] = "word=\"מקורות\"";
			//g_aWordSearchArr[2] = "word=\"זרים\"";

			
			//g_aMinWordsBetweenResults[1]=3;
			//g_aMaxWordsBetweenResults[1]=3;

			//g_aMinWordsBetweenResults[2]=3;
				
			UpdateWordsBetweenResults();
			WriteQuery();
	
	
			//myTextField2.value += " !The End! " + myTextField.value;
		}
	}

	function UpdateWordsBetweenResults()
	{
		var TempTextBox = document.getElementById('MinWordsBetweenResults[0]TextBox');
		if(TempTextBox.value)
			g_aMinWordsBetweenResults[0] = parseInt(TempTextBox.value,10);
		else
			g_aMinWordsBetweenResults[0] = null;
		TempTextBox = document.getElementById('MaxWordsBetweenResults[0]TextBox');
		if(TempTextBox.value)
			g_aMaxWordsBetweenResults[0] = parseInt(TempTextBox.value,10);
		else
			g_aMaxWordsBetweenResults[0] = null;

		TempTextBox = document.getElementById('MinWordsBetweenResults[1]TextBox');
		if(TempTextBox.value)
			g_aMinWordsBetweenResults[1] = parseInt(TempTextBox.value,10);
		else
			g_aMinWordsBetweenResults[1] = null;
		TempTextBox = document.getElementById('MaxWordsBetweenResults[1]TextBox');
		if(TempTextBox.value)
			g_aMaxWordsBetweenResults[1] = parseInt(TempTextBox.value,10);
		else
			g_aMaxWordsBetweenResults[1] = null;

		TempTextBox = document.getElementById('MinWordsBetweenResults[2]TextBox');
		if(TempTextBox.value)
			g_aMinWordsBetweenResults[2] = parseInt(TempTextBox.value,10);
		else
			g_aMinWordsBetweenResults[2] = null;
		TempTextBox = document.getElementById('MaxWordsBetweenResults[2]TextBox');
		if(TempTextBox.value)
			g_aMaxWordsBetweenResults[2] = parseInt(TempTextBox.value,10);
		else
			g_aMaxWordsBetweenResults[2] = null;
	}

	function UpdateSpecificWordBetweenResults(bIsMax,iIndex,iValue)
	{
		if(bIsMax)
			g_aMaxWordsBetweenResults[iIndex] = iValue;
	}

	
	function ChangeCurrentWord(iCurrentWord)
	{
		g_iCurrentWordIndex = parseInt(iCurrentWord,10);
	}

	function WriteQuery()
	{
		ClearQueryTextbox();
		var pQueryTextbox = document.getElementById('QueryTextbox');

		// for each word
		for(var ii=0;ii<NumSupportSearchWord;ii++)
		{		
			if(g_aWordSearchArr[ii])
				pQueryTextbox.value += ("[" + g_aWordSearchArr[ii] + "] ");

			// print the min&max word between results if needed
			// for X words there is X-1 spaces between them
			if(ii <NumSupportSearchWord-1)
			{
				if(g_aMinWordsBetweenResults[ii] || g_aMaxWordsBetweenResults[ii])
				{
					pQueryTextbox.value += "[]{";
					if(g_aMinWordsBetweenResults[ii])
						pQueryTextbox.value += g_aMinWordsBetweenResults[ii];
					else
						pQueryTextbox.value += 0; // max but no min => min=0
					pQueryTextbox.value += ",";
					if(g_aMaxWordsBetweenResults[ii])
						pQueryTextbox.value += g_aMaxWordsBetweenResults[ii];
					pQueryTextbox.value += "} ";	
				}
			}
		}		
	}

	function ClearQueryTextbox()
	{
		var pQueryTextbox = document.getElementById('QueryTextbox');
		pQueryTextbox.value = "";	
	}

	function ClearAll()
	{
		for(var ii=0;ii<NumSupportSearchWord;ii++)
		{
			g_aMinWordsBetweenResults[ii] = null;
			g_aMaxWordsBetweenResults[ii] = null;
			g_aWordSearchArr[ii] = null;
			ClearWordsBetweenResultsTextBox(0);
			ClearWordsBetweenResultsTextBox(1);
			ClearWordsBetweenResultsTextBox(2);
		}
		WriteQuery();
	}

	function ClearCurrnet()
	{
		g_aWordSearchArr[g_iCurrentWordIndex] = null;

		// clear the []{} before the currnet word  //  []{} is the max/min word between
		if(g_iCurrentWordIndex-1 >=0)
		{
			g_aMinWordsBetweenResults[g_iCurrentWordIndex-1] = null;
			g_aMaxWordsBetweenResults[g_iCurrentWordIndex-1] = null;
			ClearWordsBetweenResultsTextBox(g_iCurrentWordIndex-1);
		}

		// clear the []{} after the currnet word  // []{} is the max/min word between
		if(g_iCurrentWordIndex < NumSupportSearchWord-1)
		{
			g_aMinWordsBetweenResults[g_iCurrentWordIndex] = null;
			g_aMaxWordsBetweenResults[g_iCurrentWordIndex] = null;
			ClearWordsBetweenResultsTextBox(g_iCurrentWordIndex);
		}
		WriteQuery();	
	}

	function ClearWordsBetweenResultsTextBox(iIndex)
	{		
		switch(iIndex)
		{
		case 0:
			var TempTextBox = document.getElementById('MinWordsBetweenResults[0]TextBox');
			TempTextBox.value = null;
			TempTextBox = document.getElementById('MaxWordsBetweenResults[0]TextBox');
			TempTextBox.value = null;
			break;
		case 1:
			var TempTextBox = document.getElementById('MinWordsBetweenResults[1]TextBox');
			TempTextBox.value = null;
			TempTextBox = document.getElementById('MaxWordsBetweenResults[1]TextBox');
			TempTextBox.value = null;
			break;
		case 2:
			var TempTextBox = document.getElementById('MinWordsBetweenResults[2]TextBox');
			TempTextBox.value = null;
			TempTextBox = document.getElementById('MaxWordsBetweenResults[2]TextBox');
			TempTextBox.value = null;
			break;
		default:
			alert("Somthing is Wrong in ClearWordsBetweenResultsTextBox() ");
			break;	
		}
	} 

	function AppendOpenBracket() 
	{ 
		if(g_aWordSearchArr[g_iCurrentWordIndex])
			g_aWordSearchArr[g_iCurrentWordIndex] += "(";
		else
			g_aWordSearchArr[g_iCurrentWordIndex] = "(";
		WriteQuery();
	}
	function AppandCloseBracket()
	{ 
		if(g_aWordSearchArr[g_iCurrentWordIndex])
			g_aWordSearchArr[g_iCurrentWordIndex] += ")";
		else
			g_aWordSearchArr[g_iCurrentWordIndex] = ")";
		WriteQuery();
	} 
	function AppandOperatorOr()
	{ 
		if(g_aWordSearchArr[g_iCurrentWordIndex])
			g_aWordSearchArr[g_iCurrentWordIndex] += "|";
		else
			g_aWordSearchArr[g_iCurrentWordIndex] = "|";
		WriteQuery();
	} 
	function AppandOperatorAnd()
	{ 
		if(g_aWordSearchArr[g_iCurrentWordIndex])
			g_aWordSearchArr[g_iCurrentWordIndex] += "&";
		else
			g_aWordSearchArr[g_iCurrentWordIndex] = "&";
		WriteQuery();
	} 

	function isNumberKey(evt)
    {
       var charCode = (evt.which) ? evt.which : event.keyCode;
       if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
          return false;
       return true;
    }
</script>
