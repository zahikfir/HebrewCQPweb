<?php echo "[querying your desires]" ?>
<table align="center"><th class="concordtable" align="center">Query computing: </th></table>
<br/>  

<?php	require("ComputeQueryLogicLayer.php"); ?>

<div id="ComputeQueryGUI">
	
	<!--  Single target word table -->
	<table align="center">
		<tr>
			<td><button type="button" onclick="ChangeCurrentWord(0)">First Word</button></td>
			<td><button type="button" onclick="ClearTargetWord(0)">Clear</button></td>
			<td><input type='text' id='SingleTargetWord1Textbox' style="width:600px" disabled/></td>
		</tr>
		<tr>
			<td colspan="3">
				<input type='text' id='MinWordsBetweenTargets[1-2]TextBox' onkeypress="return isNumberKey(event)" style="width:25px" />
				<input type='text' id='MaxWordsBetweenTargets[1-2]TextBox' onkeypress="return isNumberKey(event)" style="width:25px"/>
				<label> - Min/Max words between Targets </label>
			</td>
		</tr>
		<tr>
			<td><button type="button" onclick="ChangeCurrentWord(1)">Second Word</button></td>
			<td><button type="button" onclick="ClearTargetWord(1)">Clear</button></td>
			<td><input type='text' id='SingleTargetWord2Textbox' style="width:600px" disabled/></td>
		</tr>
		<tr>
			<td colspan="3">
				<input type='text' id='MinWordsBetweenTargets[2-3]TextBox' onkeypress="return isNumberKey(event)" style="width:25px"/>
				<input type='text' id='MaxWordsBetweenTargets[2-3]TextBox' onkeypress="return isNumberKey(event)" style="width:25px"/>
				<label> - Min/Max words between Targets </label>
			</td>
		</tr>
		<tr>
			<td><button type="button" onclick="ChangeCurrentWord(2)">Third Word</button></td>
			<td><button type="button" onclick="ClearTargetWord(2)">Clear</button></td>
			<td><input type='text' id='SingleTargetWord3Textbox' style="width:600px" disabled/></td>
		</tr>
		<tr>
			<td colspan="3">
				<input type='text' id='MinWordsBetweenTargets[3-4]TextBox' onkeypress="return isNumberKey(event)" style="width:25px"/>
				<input type='text' id='MaxWordsBetweenTargets[3-4]TextBox' onkeypress="return isNumberKey(event)" style="width:25px"/>
				<label> - Min/Max words between Targets </label>
			</td>
		</tr>
		<tr>
			<td><button type="button" onclick="ChangeCurrentWord(3)">Forth Word</button></td>
			<td><button type="button" onclick="ClearTargetWord(3)">Clear</button></td>
			<td><input type='text' id='SingleTargetWord4Textbox' style="width:600px" disabled/></td>
		</tr>
	</table>

	<br/>
	<br/>
	<table align ="center">
	<tr align ="center"><td>
	<button type="button" onclick="AppandOperatorAnd()"> '&' (And) </button>
	<button type="button" onclick="AppandOperatorOr()"> '|' (Or) </button>
	<button type="button" onclick="AppendOpenBracket()"> '(' (OpenBracket) </button>
	<button type="button" onclick="AppandCloseBracket()"> ')' (CloseBracket) </button>
	</td></tr>
	<tr align ="center"><td>
	<button type="button" onclick="ClearAll()"> Clear-all </button>
	<button type="button" onclick="ComputeQuery()" style="width: 150px; height: 40px; font:20px bold italic ;">Compute Query</button>
	<button type="button" onclick="ClearUserMenu()"> Reset menu </button>
	</td></tr>
	</table>

	<!-- Word annotations table -->
	<table align="center" class="concordtable">
		<tr align="center">
			<th class="concordtable" style="font-size: 24px;">Word</th>
			<th class="concordtable" style="font-size: 24px;">Lexicon Item</th>
			<th class="concordtable" style="font-size: 24px;">Root</th>
		</tr>
		<tr>
			<td><input type='text' id='TargetWordTextbox' /></td>
			<td><input type='text' id='LexiconItemTextbox' /></td>
			<td><input type='text' id='RootTextbox' /></td>
		</tr>       	      
	</table>

	
	<!-- Base type attributes -->
	<table class="concordtable">
	<th class="concordtable" style="font-size: 24px;" align="left">Base</th>
	<tr>
		<td>base type: </td>
		<td>
			<select name="BaseBaseType" id="BaseBaseType" onchange="SetOptionsOfBaseTypeDropList(this.value)" >
				<option value="N"></option>
				<option value="a">adjective</option>
				<option value="b">adverb</option>
				<option value="c">zevel</option>
				<option value="d">conjunction</option>
				<option value="e">interjection</option>
				<option value="f">interrogative</option>
				<option value="g">negation</option>
				<option value="h">foreign</option>
				<option value="i">url</option>
				<option value="j">noun</option>
				<option value="k">preposition</option>
				<option value="l">pronoun</option>
				<option value="m">properName</option>
				<option value="n">punctuation</option>
				<option value="o">numberExpression</option>
				<option value="p">quantifier</option>
				<option value="q">verb</option>
				<option value="r">participle</option>
				<option value="s">numeral</option>
				<option value="t">existential</option>
				<option value="u">impersonal</option>
				<option value="v">wPrefix</option>
				<option value="w">modal</option>
				<option value="x">copula</option>
				<option value="y">title</option>
				<option value="z">MWE</option>
			</select>
		</td>
		<td>gender: </td>
		<td>
			<select name="BaseGender" id="BaseGender">
				<option value="N"></option>
				<option value="a">masculine</option>
				<option value="b">feminine</option>
				<option value="c">masculine and feminine</option>
			</select>
			</td>
		<td>number: </td>
		<td>
			<select name="BaseNumber" id="BaseNumber">
				<option value="N"></option>
				<option value="a">singular</option>
				<option value="b">plural</option>
				<option value="c">dual</option>
				<option value="d">dual and plural</option>
				<option value="e">singular and plural</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>status: </td>
		<td>
			<select name="BaseStatus" id="BaseStatus">
				<option value="N"></option>
				<option value="a">absolute</option>
				<option value="b">construct</option>
				<option value="c">absolute and construct</option>
			</select>
		</td>
		<td>definiteness: </td>
		<td>
			<select name="BaseDefiniteness" id="BaseDefiniteness">
				<option value="N"></option>
				<option value="a">1</option>
				<option value="b">0</option>
			</select>
		</td>
		<td>foreign: </td>
		<td>
			<select name="BaseForeign" id="BaseForeign">
				<option value="N"></option>
				<option value="a">1</option>
				<option value="b">0</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>register:</td>
		<td>
			<select name="BaseRegister" id="BaseRegister">
				<option value="N"></option>
				<option value="a">formal</option>
				<option value="b">archaic</option>
				<option value="c">informal</option>
			</select>
		</td>
		<td>spelling:</td>
		<td>
			<select name="BaseSpelling" id="BaseSpelling">
				<option value="N"></option>
				<option value="a">standard</option>
				<option value="b">irregular</option>
			</select>
		</td>
		<td>person: </td>
		<td>
			<select name="BasePerson" id="BasePerson">
				<option value="N"></option>
				<option value="a">first</option>
				<option value="b">second</option>
				<option value="c">third</option>
				<option value="d">any</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>tense:</td>
		<td>
			<select name="BaseTense" id="BaseTense">
				<option value="N"></option>
				<option value="a">past</option>
				<option value="b">present</option>
				<option value="c">beinoni</option>
				<option value="d">future</option>
				<option value="e">imperative</option>
				<option value="f">infinitive</option>
				<option value="g">bareInfinitive</option>
			</select>
		</td>
		<td>binyan: </td>
		<td>
			<select name="BaseBinyan" id="BaseBinyan">
				<option value="N"></option>
				<option value="a">Pa'al</option>
				<option value="b">Nif'al</option>
				<option value="c">Pi'el</option>
				<option value="d">Pu'al</option>
				<option value="e">Hif'il</option>
				<option value="f">Huf'al</option>
				<option value="g">Hitpa'el</option>
			</select>
		</td>
		<td>polarity:</td>
		<td>
			<select name="BasePolarity" id="BasePolarity">
				<option value="N"></option>
				<option value="a">positive</option>
				<option value="b">negative</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>multiWord prefix exist: </td>
		<td>
			<select name="BaseMultiWordPrefix" id="BaseMultiWordPrefix">
				<option value="N"></option>
				<option value="a">1</option>
				<option value="b">0</option>
			</select>
		</td>
		<td>type: </td>
		<td colspan="3">
			<select name="BaseType" id="BaseType">
				<option value="N"></option>
			</select>
		</td>
	</tr>
</table>

<table class="concordtable">
	<th class="concordtable" style="font-size: 24px;">Prefixes</th>
	<tr>
		<td style="color: red;">Prefix 1 :</td>
		<td>surface:</td>
		<td>
			<select name="prefix1surface" id="prefix1surface">
				<option value="N"></option>
				<option value="a">'מ'</option>
				<option value="b">'ש'</option>
				<option value="c">'ה'</option>
				<option value="d">'ו'</option>
				<option value="e">'כ'</option>
				<option value="f">'ל'</option>
				<option value="g">'ב'</option>
				<option value="h">'כש'</option>
				<option value="i">'מש'</option>
				<option value="j">'מב'</option>
				<option value="k">'מל'</option>
				<option value="l">'בש'</option>
				<option value="m">'לכש'</option>
			</select>
		</td>
		<td>function: </td>
		<td>
			<select name="prefix1function" id="prefix1function">
				<option value="N"></option>
				<option value="a">relativizer</option>
				<option value="b">conjunction</option>
				<option value="c">definite article</option>
				<option value="d">subordinatingConjunction</option>
				<option value="e">relativizer/subConj</option>
				<option value="f">temporalSubConj</option>
				<option value="g">interrogative</option>
				<option value="h">tenseInversion</option>
				<option value="i">preposition</option>
				<option value="j">adverb</option>
			</select>
		</td>
		<td>multiword:</td>
		<td>
			<select name="prefix1multiword" id="prefix1multiword">
				<option value="N"></option>
				<option value="a">1</option>
				<option value="b">0</option>
			</select>
		</td>
	</tr>
	<tr>
		<td style="color: red;">Prefix 2 :</td>
		<td>surface:</td>
		<td>
			<select name="prefix2surface" id="prefix2surface">
				<option value="N"></option>
				<option value="a">'מ'</option>
				<option value="b">'ש'</option>
				<option value="c">'ה'</option>
				<option value="d">'ו'</option>
				<option value="e">'כ'</option>
				<option value="f">'ל'</option>
				<option value="g">'ב'</option>
				<option value="h">'כש'</option>
				<option value="i">'מש'</option>
				<option value="j">'מב'</option>
				<option value="k">'מל'</option>
				<option value="l">'בש'</option>
				<option value="m">'לכש'</option>
			</select>
		</td>
		<td>function: </td>
		<td>
			<select name="prefix2function" id="prefix2function">
				<option value="N"></option>
				<option value="a">relativizer</option>
				<option value="b">conjunction</option>
				<option value="c">definite article</option>
				<option value="d">subordinatingConjunction</option>
				<option value="e">relativizer/subConj</option>
				<option value="f">temporalSubConj</option>
				<option value="g">interrogative</option>
				<option value="h">tenseInversion</option>
				<option value="i">preposition</option>
				<option value="j">adverb</option>
			</select>
		</td>
		<td>multiword:</td>
		<td>
			<select name="prefix2multiword" id="prefix2multiword">
				<option value="N"></option>
				<option value="a">1</option>
				<option value="b">0</option>
			</select>
		</td>
	</tr>
	<tr>
		<td style="color: red;">Prefix 3 :</td>
		<td>surface:</td>
		<td>
			<select name="prefix3surface" id="prefix3surface">
				<option value="N"></option>
				<option value="a">'מ'</option>
				<option value="b">'ש'</option>
				<option value="c">'ה'</option>
				<option value="d">'ו'</option>
				<option value="e">'כ'</option>
				<option value="f">'ל'</option>
				<option value="g">'ב'</option>
				<option value="h">'כש'</option>
				<option value="i">'מש'</option>
				<option value="j">'מב'</option>
				<option value="k">'מל'</option>
				<option value="l">'בש'</option>
				<option value="m">'לכש'</option>
			</select>
		</td>
		<td>function: </td>
		<td>
			<select name="prefix3function" id="prefix3function">
				<option value="N"></option>
				<option value="a">relativizer</option>
				<option value="b">conjunction</option>
				<option value="c">definite article</option>
				<option value="d">subordinatingConjunction</option>
				<option value="e">relativizer/subConj</option>
				<option value="f">temporalSubConj</option>
				<option value="g">interrogative</option>
				<option value="h">tenseInversion</option>
				<option value="i">preposition</option>
				<option value="j">adverb</option>
			</select>
		</td>
		<td>multiword:</td>
		<td>
			<select name="prefix3multiword" id="prefix3multiword">
				<option value="N"></option>
				<option value="a">1</option>
				<option value="b">0</option>
			</select>
		</td>
	</tr>
	<tr>
		<td style="color: red;">Prefix 4 :</td>
		<td>surface:</td>
		<td>
			<select name="prefix4surface" id="prefix4surface">
				<option value="N"></option>
				<option value="a">'מ'</option>
				<option value="b">'ש'</option>
				<option value="c">'ה'</option>
				<option value="d">'ו'</option>
				<option value="e">'כ'</option>
				<option value="f">'ל'</option>
				<option value="g">'ב'</option>
				<option value="h">'כש'</option>
				<option value="i">'מש'</option>
				<option value="j">'מב'</option>
				<option value="k">'מל'</option>
				<option value="l">'בש'</option>
				<option value="m">'לכש'</option>
			</select>
		</td>
		<td>function: </td>
		<td>
			<select name="prefix4function" id="prefix4function">
				<option value="N"></option>
				<option value="a">relativizer</option>
				<option value="b">conjunction</option>
				<option value="c">definite article</option>
				<option value="d">subordinatingConjunction</option>
				<option value="e">relativizer/subConj</option>
				<option value="f">temporalSubConj</option>
				<option value="g">interrogative</option>
				<option value="h">tenseInversion</option>
				<option value="i">preposition</option>
				<option value="j">adverb</option>
			</select>
		</td>
		<td>multiword:</td>
		<td>
			<select name="prefix4multiword" id="prefix4multiword">
				<option value="N"></option>
				<option value="a">1</option>
				<option value="b">0</option>
			</select>
		</td>
	</tr>
	<tr>
		<td style="color: red;">Prefix 5 :</td>
		<td>surface:</td>
		<td>
			<select name="prefix5surface" id="prefix5surface">
				<option value="N"></option>
				<option value="a">'מ'</option>
				<option value="b">'ש'</option>
				<option value="c">'ה'</option>
				<option value="d">'ו'</option>
				<option value="e">'כ'</option>
				<option value="f">'ל'</option>
				<option value="g">'ב'</option>
				<option value="h">'כש'</option>
				<option value="i">'מש'</option>
				<option value="j">'מב'</option>
				<option value="k">'מל'</option>
				<option value="l">'בש'</option>
				<option value="m">'לכש'</option>
			</select>
		</td>
		<td>function: </td>
		<td>
			<select name="prefix5function" id="prefix5function">
				<option value="N"></option>
				<option value="a">relativizer</option>
				<option value="b">conjunction</option>
				<option value="c">definite article</option>
				<option value="d">subordinatingConjunction</option>
				<option value="e">relativizer/subConj</option>
				<option value="f">temporalSubConj</option>
				<option value="g">interrogative</option>
				<option value="h">tenseInversion</option>
				<option value="i">preposition</option>
				<option value="j">adverb</option>
			</select>
		</td>
		<td>multiword:</td>
		<td>
			<select name="prefix5multiword" id="prefix5multiword">
				<option value="N"></option>
				<option value="a">1</option>
				<option value="b">0</option>
			</select>
		</td>
	</tr>
	<tr>
		<td style="color: red;">Prefix 6 :</td>
		<td>surface:</td>
		<td>
			<select name="prefix6surface" id="prefix6surface">
				<option value="N"></option>
				<option value="a">'מ'</option>
				<option value="b">'ש'</option>
				<option value="c">'ה'</option>
				<option value="d">'ו'</option>
				<option value="e">'כ'</option>
				<option value="f">'ל'</option>
				<option value="g">'ב'</option>
				<option value="h">'כש'</option>
				<option value="i">'מש'</option>
				<option value="j">'מב'</option>
				<option value="k">'מל'</option>
				<option value="l">'בש'</option>
				<option value="m">'לכש'</option>
			</select>
		</td>
		<td>function: </td>
		<td>
			<select name="prefix6function" id="prefix6function">
				<option value="N"></option>
				<option value="a">relativizer</option>
				<option value="b">conjunction</option>
				<option value="c">definite article</option>
				<option value="d">subordinatingConjunction</option>
				<option value="e">relativizer/subConj</option>
				<option value="f">temporalSubConj</option>
				<option value="g">interrogative</option>
				<option value="h">tenseInversion</option>
				<option value="i">preposition</option>
				<option value="j">adverb</option>
			</select>
		</td>
		<td>multiword:</td>
		<td>
			<select name="prefix6multiword" id="prefix6multiword">
				<option value="N"></option>
				<option value="a">1</option>
				<option value="b">0</option>
			</select>
		</td>
	</tr>
	

</table>
	
<table class="concordtable">
	<th class="concordtable" style="font-size: 24px;">Suffix</th>
	<tr>
		<td>surface:</td>
		<td>
			<select name="sufixSurface" id="sufixSurface">
				<option value="N"></option>
				<option value="a">'י'</option>
				<option value="b">'ך'</option>
				<option value="c">'ו'</option>
				<option value="d">'ה'</option>
				<option value="e">'נו'</option>
				<option value="f">'כם'</option>
				<option value="g">'כן'</option>
				<option value="h">'ם'</option>
				<option value="i">'ן'</option>
				<option value="j">'יך'</option>
				<option value="k">'יו'</option>
				<option value="l">'יה'</option>
				<option value="m">'ינו'</option>
				<option value="n">'יכם'</option>
				<option value="o">'יכן'</option>
				<option value="p">'יהם'</option>
				<option value="q">'יהן'</option>
			</select>
		</td>
		<td>function:</td>
		<td>
			<select name="sufixFunction" id="sufixFunction">
				<option value="N"></option>
				<option value="a">possessive</option>
				<option value="b">accusative</option>
				<option value="c">nominative</option>
				<option value="d">accusative or nominative</option>
				<option value="e">pronomial</option>
			</select>
		</td>
		<td>person:</td>
		<td>
			<select name="sufixPerson" id="sufixPerson">
				<option value="N"></option>
				<option value="a">first</option>
				<option value="b">second</option>
				<option value="c">third</option>
				<option value="d">any</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>gender:</td>
		<td>
			<select name="sufixGender" id="sufixGender">
				<option value="N"></option>
				<option value="a">masculine</option>
				<option value="b">feminine</option>
				<option value="c">masculine and feminine</option>
			</select>
		</td>
		<td>number:</td>
		<td>
			<select name="sufixNumber" id="sufixNumber">
				<option value="N"></option>
				<option value="a">singular</option>
				<option value="b">plural</option>
				<option value="c">dual</option>
				<option value="d">dual and plural</option>
				<option value="e">singular and plural</option>
			</select>
		</td>
	</tr>	
</table>

<table class="concordtable">
	<th class="concordtable" style="font-size: 24px;" colspan="2" align="left">Open Attributes</th>
	<tr>
		<td>Expansion:</td>
		<td><input type='text' id='ExpansionTextbox' /></td>
		<td>Function:</td>
		<td><input type='text' id='FunctionTextbox' /></td>
	</tr>
	<tr>
		<td>Subcoordinating:</td>
		<td><input type='text' id='SubcoordinatingTextbox' /></td>
		<td>Mood:</td>
		<td><input type='text' id='MoodTextbox' /></td>
	</tr>
	<tr>
		<td>Value:</td>
		<td><input type='text' id='ValueTextbox' /></td>
		<td>Id:</td>
		<td><input type='text' id='IdTextbox' /></td>
	</tr>
	<tr>
		<td>Pos:</td>
		<td><input type='text' id='PosTextbox' /></td>
		<td>consecutive:</td>
		<td><input type='text' id='ConsecutiveTextbox' /></td>
	</tr>
	<tr>
		<td>MultiWord:</td>
		<td><input type='text' id='MultiWordTextbox' /></td>
		<td>MWE:</td>
		<td><input type='text' id='MweTextbox' /></td>
	</tr>
		
</table>

<table align="center">
	<tr>
		<td>
			<button type="button" onclick="ResetDropListsMenu()"> Reset DropLists </button>
			<button type="button" onclick="ClearAllUserInputTextBoxes()"> Reset TextBoxes </button>
		</td>
	</tr>
</table>
	
	
	


	
</div>
<!--
<br/><br/><label><b><u></b></u></label>
		<br/><label><b>: </b></label>
			<select name="" id="">
				<option value="N"></option>
				<option value="a"></option>
				<option value="b"></option>
				<option value="c"></option>
				<option value="d"></option>
				<option value="e"></option>
				<option value="f"></option>
				<option value="g"></option>
				<option value="h"></option>
				<option value="i"></option>
				<option value="j"></option>
				<option value="k"></option>
				<option value="l"></option>
				<option value="m"></option>
				<option value="n"></option>
				<option value="o"></option>
				<option value="p"></option>
				<option value="q"></option>
				<option value="r"></option>
				<option value="s"></option>
				<option value="t"></option>
				<option value="u"></option>
				<option value="v"></option>
				<option value="w"></option>
				<option value="x"></option>
				<option value="y"></option>
				<option value="z"></option>
			</select>
-->
























