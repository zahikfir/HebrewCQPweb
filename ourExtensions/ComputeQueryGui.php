<?php echo "[querying your desires]" ?>
<h1>Query computing: </h1><br/>  

<?php	require("ComputeQueryLogicLayer.php"); ?>

<div id="ComputeQueryGUI">
	
	<button type="button" onclick="ChangeCurrentWord(0)">First Word</button>
	<button type="button" onclick="ClearCurrnet(0)">Clear</button>
	<input type='text' id='SingleTargetWord1Textbox' style="width:600px" disabled/> <br/>	
	<input type='text' id='MinWordsBetweenTargets[1-2]TextBox' onkeypress="return isNumberKey(event)" style="width:25px" />
	<input type='text' id='MaxWordsBetweenTargets[1-2]TextBox' onkeypress="return isNumberKey(event)" style="width:25px"/>
	<label> - Min/Max words between Targets </label>
	<br/>
	<button type="button" onclick="ChangeCurrentWord(1)">Second Word</button>
	<button type="button" onclick="ClearCurrnet(1)">Clear</button>
	<input type='text' id='SingleTargetWord2Textbox' style="width:600px" disabled/> <br/>
	<input type='text' id='MinWordsBetweenTargets[2-3]TextBox' onkeypress="return isNumberKey(event)" style="width:25px"/>
	<input type='text' id='MaxWordsBetweenTargets[2-3]TextBox' onkeypress="return isNumberKey(event)" style="width:25px"/>
	<label> - Min/Max words between Targets </label>
	<br/>
	<button type="button" onclick="ChangeCurrentWord(2)">Third Word</button>
	<button type="button" onclick="ClearCurrnet(2)">Clear</button>
	<input type='text' id='SingleTargetWord3Textbox' style="width:600px" disabled/> <br/>
	<input type='text' id='MinWordsBetweenTargets[3-4]TextBox' onkeypress="return isNumberKey(event)" style="width:25px"/>
	<input type='text' id='MaxWordsBetweenTargets[3-4]TextBox' onkeypress="return isNumberKey(event)" style="width:25px"/>
	<label> - Min/Max words between Targets </label>
	<br/>
	<button type="button" onclick="ChangeCurrentWord(3)">Forth Word</button>
	<button type="button" onclick="ClearCurrnet(3)">Clear</button>
	<input type='text' id='SingleTargetWord4Textbox' style="width:600px" disabled/>	
	<br/><br/>

	<button type="button" onclick="AppandOperatorAnd()"> '&' (And) </button>
	<button type="button" onclick="AppandOperatorOr()"> '|' (Or) </button>
	<button type="button" onclick="AppendOpenBracket()"> '(' (OpenBracket) </button>
	<button type="button" onclick="AppandCloseBracket()"> ')' (OpenBracket) </button>
	<button type="button" onclick="ClearAll()"> Clear-all </button>
	<br/><br/>
	
	<input type='text' id='TargetWordTextbox' />
	<button type="button" onclick="ComputeQuery()">Compute Query</button>
	<button type="button" onclick="ResetDropListsMenu()"> Reset menu </button>
	<br/>
	<form id="queryComputeForm" onsubmit="return MyFunc()" method="post">
	
		<p>
		<label><b><u>First prefix</b></u></label>
			<br/><label><b>surface: </b></label>
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
			<br/><label><b>function: </b></label>
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
			<br/><label><b>multiword: </b></label>
				<select name="prefix1multiword" id="prefix1multiword">
					<option value="N"></option>
					<option value="a">1</option>
					<option value="b">0</option>
				</select>
	
	
	
		<br/><br/><label><b><u>Second prefix</b></u></label>
			<br/><label><b>surface: </b></label>
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
			<br/><label><b>function: </b></label>
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
			<br/><label><b>multiword: </b></label>
				<select name="prefix2multiword" id="prefix2multiword">
					<option value="N"></option>
					<option value="a">1</option>
					<option value="b">0</option>
				</select>
	
	
	
		<br/><br/><label><b><u>Third prefix</b></u></label>
			<br/><label><b>surface: </b></label>
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
			<br/><label><b>function: </b></label>
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
			<br/><label><b>multiword: </b></label>
				<select name="prefix3multiword" id="prefix3multiword">
					<option value="N"></option>
					<option value="a">1</option>
					<option value="b">0</option>
				</select>
	
	
	
		<br/><br/><label><b><u>Fourth prefix</b></u></label>
			<br/><label><b>surface: </b></label>
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
			<br/><label><b>function: </b></label>
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
			<br/><label><b>multiword: </b></label>
				<select name="prefix4multiword" id="prefix4multiword">
					<option value="N"></option>
					<option value="a">1</option>
					<option value="b">0</option>
				</select>
	
	
	
		<br/><br/><label><b><u>Fith prefix</b></u></label>
			<br/><label><b>surface: </b></label>
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
			<br/><label><b>function: </b></label>
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
			<br/><label><b>multiword: </b></label>
				<select name="prefix5multiword" id="prefix5multiword">
					<option value="N"></option>
					<option value="a">1</option>
					<option value="b">0</option>
				</select>
	
	
	
		<br/><br/><label><b><u>Sixth prefix</b></u></label>
			<br/><label><b>surface: </b></label>
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
			<br/><label><b>function: </b></label>
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
			<br/><label><b>multiword: </b></label>
				<select name="prefix6multiword" id="prefix6multiword">
					<option value="N"></option>
					<option value="a">1</option>
					<option value="b">0</option>
				</select>
	
	
	
		<br/><br/><label><b><u>Base</b></u></label>
			<br/><label><b>base type: </b></label>
				<select name="BaseBaseType" id="BaseBaseType">
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
			<br/><label><b>gender: </b></label>
				<select name="BaseGender" id="BaseGender">
					<option value="N"></option>
					<option value="a">masculine</option>
					<option value="b">feminine</option>
					<option value="c">masculine and feminine</option>
				</select>
			<br/><label><b>number: </b></label>
				<select name="BaseNumber" id="BaseNumber">
					<option value="N"></option>
					<option value="a">singular</option>
					<option value="b">plural</option>
					<option value="c">dual</option>
					<option value="d">dual and plural</option>
					<option value="e">singular and plural</option>
				</select>
			<br/><label><b>status: </b></label>
				<select name="BaseStatus" id="BaseStatus">
					<option value="N"></option>
					<option value="a">absolute</option>
					<option value="b">construct</option>
					<option value="c">absolute and construct</option>
				</select>
			<br/><label><b>definiteness: </b></label>
				<select name="BaseDefiniteness" id="BaseDefiniteness">
					<option value="N"></option>
					<option value="a">1</option>
					<option value="b">0</option>
				</select>
			<br/><label><b>foreign: </b></label>
				<select name="BaseForeign" id="BaseForeign">
					<option value="N"></option>
					<option value="a">1</option>
					<option value="b">0</option>
				</select>
			<br/><label><b>register: </b></label>
				<select name="BaseRegister" id="BaseRegister">
					<option value="N"></option>
					<option value="a">formal</option>
					<option value="b">archaic</option>
					<option value="c">informal</option>
				</select>
			<br/><label><b>spelling: </b></label>
				<select name="BaseSpelling" id="BaseSpelling">
					<option value="N"></option>
					<option value="a">standard</option>
					<option value="b">irregular</option>
				</select>
			<br/><label><b>person: </b></label>
				<select name="BasePerson" id="BasePerson">
					<option value="N"></option>
					<option value="a">first</option>
					<option value="b">second</option>
					<option value="c">third</option>
					<option value="d">any</option>
				</select>
			<br/><label><b>tense: </b></label>
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
			<br/><label><b>binyan: </b></label>
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
			<br/><label><b>polarity: </b></label>
				<select name="BasePolarity" id="BasePolarity">
					<option value="N"></option>
					<option value="a">positive</option>
					<option value="b">negative</option>
				</select>
			<br/><label><b>multiWord Prefix Exist: </b></label>
				<select name="BaseMultiWordPrefix" id="BaseMultiWordPrefix">
					<option value="N"></option>
					<option value="a">1</option>
					<option value="b">0</option>
				</select>
	
	
	
		<br/><br/><label><b><u>Sufix</b></u></label>
			<br/><label><b>surface: </b></label>
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
			<br/><label><b>function: </b></label>
				<select name="sufixFunction" id="sufixFunction">
					<option value="N"></option>
					<option value="a">possessive</option>
					<option value="b">accusative</option>
					<option value="c">nominative</option>
					<option value="d">accusative or nominative</option>
					<option value="e">pronomial</option>
				</select>
			<br/><label><b>person: </b></label>
				<select name="sufixPerson" id="sufixPerson">
					<option value="N"></option>
					<option value="a">first</option>
					<option value="b">second</option>
					<option value="c">third</option>
					<option value="d">any</option>
				</select>
			<br/><label><b>gender: </b></label>
				<select name="sufixGender" id="sufixGender">
					<option value="N"></option>
					<option value="a">masculine</option>
					<option value="b">feminine</option>
					<option value="c">masculine and feminine</option>
				</select>
			<br/><label><b>number: </b></label>
				<select name="sufixNumber" id="sufixNumber">
					<option value="N"></option>
					<option value="a">singular</option>
					<option value="b">plural</option>
					<option value="c">dual</option>
					<option value="d">dual and plural</option>
					<option value="e">singular and plural</option>
				</select>
		<br/><br/><br/>
	</form>
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
























