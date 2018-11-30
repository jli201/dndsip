package ga.dndsip.selenium.statModifiers;
import java.util.concurrent.TimeUnit;
import java.util.Random;
import java.util.Arrays;
import java.util.List;
import java.util.ArrayList;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;

public class STAT_MODS_SELENIUM {
	
	WebDriver driver;
	
	//Set this as true if you want the test data to give more detail than: "type = this, pass/fail"
	boolean verboseTests = false;
	
	
	//This funciton is used to set up the google chrome driver and navagate to dndsip.ga
	public void invokeBrowser() {
		try {
			System.setProperty("webdriver.chrome.driver", "C:\\Users\\Connor\\Desktop\\Selenium\\chromedriver.exe");
			driver = new ChromeDriver();
			driver.manage().deleteAllCookies();
			driver.manage().window().maximize();
			driver.manage().timeouts().implicitlyWait(30, TimeUnit.SECONDS);
			driver.manage().timeouts().pageLoadTimeout(30, TimeUnit.SECONDS);
			
			driver.get("https://dndsip.ga");
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	//This function is to quickly navigate the login page and get to the player character page
	public void driveByLoginToPlayerCharacters() {
		
		try {
			//Find username box and enter username
			driver.findElement(By.name("username")).sendKeys("jensen");
			
			//Find password box and enter password
			driver.findElement(By.name("password")).sendKeys("password");
			
			//Find login button and click it
			driver.findElement(By.id("submit")).click();
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	//This function is to quickly navigate the player character page and get to the character sheet page
	public void driveByPlayerCharactersToCharacterSheet() {
		
		try {
			//make a list of characters
			List<WebElement> characters = driver.findElements(By.className("characterSelectButton"));

			//Go to the last character sheet and click it
			characters.get(characters.size()-1).click();
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
	}
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//UTILITY FUNCTIONS
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	//This is a simple function that adds 2 strings together
	public String add2Strings(String input, String modifier) {
		try {
			String sum = "";
			
			//convert everything to an int, then add them
			int tempInput = Integer.parseInt(input);
			int tempModifier = Integer.parseInt(modifier);
			int tempSum = tempInput + tempModifier;
			sum = "" + tempSum;
			
			return sum;
		} catch (NumberFormatException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
			return "";
		}
	}
	
	//There were a lot of instances where we needed to increment/decrement the proficiency by 1, so this is a shorthand function
	public void changeProficiency(String inputProficiency, String mod) {
		//Proficiency = CurrentProficiency + mod
		inputProficiency = add2Strings(inputProficiency, mod);
		
		//clear current proficiency
		driver.findElement(By.id("proficiency")).clear();
		
		//set new proficiency
		driver.findElement(By.id("proficiency")).sendKeys(inputProficiency);
	}
	//Get the input proficiency of charSheet. If this element isn't set, set it to 2
	public String getInputProficiency() {
		String inputProficiency = driver.findElement(By.id("proficiency")).getAttribute("value");
		if(inputProficiency.equals("")) {
			inputProficiency = "2";
			driver.findElement(By.id("proficiency")).clear();
			driver.findElement(By.id("proficiency")).sendKeys("2");
		}
		return inputProficiency;
	}
	
	public void printTestOutput(String testTitle, String result, String inputTested, String inputValue, String expectedValue) {
		//Some pretty looking error checking
		if(verboseTests) {
			System.out.println(testTitle + ":");
			System.out.println("   inputStat = " + inputTested + ", inputValue = " + inputValue + ", expectedValue = " + expectedValue +":");
			System.out.println("   result: " + result);
		}else {
			System.out.println(testTitle + ", " + inputTested + ": " + result);
		}
	}
	
	//This function saves the page, backs out, and then goes back in so a function can check if the page was loaded correctly
	public void saveAndReload() {
		try {
			//save the page
			driver.findElement(By.name("save")).click();
			
			//Leave character page
			driver.findElement(By.name("backToCharacters")).click();
			
			//Go back to same character sheet
			driveByPlayerCharactersToCharacterSheet();
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//END OF UTILITY FUNCTIONS
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// CHARACTER SHEET TESTS
	// ONLY RUN THESE TESTS IF YOU'RE CURRENTLY ON THE CHARACTER SHEET
	//////////////////////////////////////////////////////////////////////////////t////////////////////////////////
	/*
	* inputStat is the stat we're focusing on for this test, inputValue is the value we're setting the stat mods to, expectedValue is the modifier we're expecting to see given the inputStat
	* This test cycles through all stats and checks all relevant skills, saves, ect. to ensure everything recieved the modifier
	*/
	public String testOneStatMod(String inputStat, String inputValue, String expectedValue) {
		
		try {
			//This test value is what we hope is = to the expected value
			String testValue = "";
			
			//This is the modifier that we want to see get the right value
			String inputModifier = inputStat.substring(0,3) + "Mod";
			
			//Clear any field that we're going put inputs in
			driver.findElement(By.id(inputStat)).clear();
			
			//input the value we're using to test
			driver.findElement(By.id(inputStat)).sendKeys(inputValue);
			
			//get the value we're testing for
			testValue = driver.findElement(By.id(inputModifier)).getText();
			
			//See how well we did
			if(testValue.equals(expectedValue))
				return "pass";
			else 
				return "fail";
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
			return "";
		}
	}
	
	
	
	public String testOneSavingThrowWithoutProficiency(String inputStat, String inputValue, String expectedValue) {
		try {
			//This test value is what we hope is = to the expected value
			String testValue = "";
			
			//This is how we identify the proficiency checkbox for the stat we're testing
			String inputCheckBox = inputStat.substring(0,3) + "Checkbox";
			
			//A WebElement to keep track of the proficiency checkbox. Not necessary but it cleans up the code
			WebElement profCheckBox = driver.findElement(By.id(inputCheckBox));
			
			//This is the saving throw we want to test
			String inputSavingThrow = inputStat + "SavingThrow";
				
			//Uncheck the profCheckBox if it is checked
			if(profCheckBox.isSelected())
				profCheckBox.click();
			
			//Clear any field that we're going put inputs in
			driver.findElement(By.id(inputStat)).clear();
			
			//input the value we're using to test
			driver.findElement(By.id(inputStat)).sendKeys(inputValue);
			
			//get the value we're testing for
			testValue = driver.findElement(By.id(inputSavingThrow)).getAttribute("value");
			
			//See how well we did
			if(testValue.equals(expectedValue))
				return "pass";
			else
				return "fail";
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
			return "";
		}
		
	}
	
	public void testDriverTestOneSavingThrow(String inputStat, String inputValue, String expectedValue){
		String result = "";
		
		//Test Saving throw without proficiency
			result = testOneSavingThrowWithProficiency(inputStat, inputValue, expectedValue);
			
			//Some pretty looking error checking
			printTestOutput("Saving Throw w/o proficiency", result, inputStat, inputValue, expectedValue);
		
		//Test Saving throw with proficiency
			result = testOneSavingThrowWithoutProficiency(inputStat, inputValue, expectedValue);
			
			//Some pretty looking error checking
			printTestOutput("Saving Throw w/ proficiency", result, inputStat, inputValue, expectedValue);
			
		//Test Saving throw proficiency change
			result = testOneSavingThrowProficiencyChange(inputStat, inputValue, expectedValue);
			
			//Some pretty looking error checking
			printTestOutput("Saving Throw proficiency change", result, inputStat, inputValue, expectedValue);
	}
	
	public String testOneSavingThrowWithProficiency(String inputStat, String inputValue, String expectedValue) {
		try {
			//This test value is what we hope is = to the expected value
			String testValue = "";
			
			//This is how we identify the proficiency checkbox for the stat we're testing
			String inputCheckBox = inputStat.substring(0,3) + "Checkbox";
			
			//A WebElement to keep track of the proficiency checkbox. Not necessary but it cleans up the code
			WebElement profCheckBox = driver.findElement(By.id(inputCheckBox));
			
			//This is the saving throw we want to test
			String inputSavingThrow = inputStat + "SavingThrow";
			
			//Get the current value of the input box
			String inputProficiency = getInputProficiency();
				
			//Check the profCheckBox if it is unchecked
			if(!profCheckBox.isSelected())
				profCheckBox.click();
			
			//Clear any field that we're going put inputs in
			driver.findElement(By.id(inputStat)).clear();
			
			//input the value we're using to test
			driver.findElement(By.id(inputStat)).sendKeys(inputValue);
			
			//get testValue again, now the proficiency box is checked it should have changed
			testValue = driver.findElement(By.id(inputSavingThrow)).getAttribute("value");
			
			//hardcode the proficiency bonus into the expected value
			expectedValue = add2Strings(expectedValue, inputProficiency);
			
			//See how well we did
			if(testValue.equals(expectedValue))
				return "pass";
			else 
				return "fail";
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
			return "";
		}
	}
	
	//This is basically "testOneSavingThrowWithProficiency" except it doesn't use the inputValue, and thus can be used without accidentaly resetting the values we're trying to test
	public String testOneSavingThrowProficiencyChangeHelper(String inputStat, String expectedValue) {
		try {
			//This test value is what we hope is = to the expected value
			String testValue = "";
			
			//This is how we identify the proficiency checkbox for the stat we're testing
			String inputCheckBox = inputStat.substring(0,3) + "Checkbox";
			
			//A WebElement to keep track of the proficiency checkbox. Not necessary but it cleans up the code
			WebElement profCheckBox = driver.findElement(By.id(inputCheckBox));
			
			//This is the saving throw we want to test
			String inputSavingThrow = inputStat + "SavingThrow";
			
			//Get the current value of the input box
			String inputProficiency = getInputProficiency();
				
			//Check the profCheckBox if it is unchecked
			if(!profCheckBox.isSelected())
				profCheckBox.click();
			
			//get testValue again, now the proficiency box is checked it should have changed
			testValue = driver.findElement(By.id(inputSavingThrow)).getAttribute("value");
			
			//hardcode the proficiency bonus into the expected value
			expectedValue = add2Strings(expectedValue, inputProficiency);
			
			//See how well we did
			if(testValue.equals(expectedValue))
				return "pass";
			else 
				return "fail";
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
			return "";
		}
	}
	
	public String testOneSavingThrowProficiencyChange(String inputStat, String inputValue, String expectedValue) {
		
		//Clear any field that we're going put inputs in
		driver.findElement(By.id(inputStat)).clear();
		
		//input the value we're using to test
		driver.findElement(By.id(inputStat)).sendKeys(inputValue);
		
		if(testOneSavingThrowProficiencyChangeHelper(inputStat, expectedValue) == "pass") {
			//get the current proficiency modifier and add 1. Then set the proficiency to this new number
				//get current proficiency modifier
				String inputProficiency = getInputProficiency();
				
				//add 1 to the proficiency
				changeProficiency(inputProficiency, "1");
		
			//now that we've added 1 to the proficiency
			if(testOneSavingThrowProficiencyChangeHelper(inputStat, expectedValue) == "pass") {
				//This is just a little clean-up bit where we set the proficiency mod back to what it was before
				//changeProficiency decrements with 0 instead of -1
				changeProficiency(inputProficiency, "0");
				return "pass";
			}else {
				//This is just a little clean-up bit where we set the proficiency mod back to what it was before
				//changeProficiency decrements with 0 instead of -1
				changeProficiency(inputProficiency, "0");
				return "fail";
			}
			
		}else
			return "fail";
	}
	
	public String testOneSkillWithoutProficiency(String inputSkill, String inputValue, String expectedValue) {
		//This test value is what we hope is = to the expected value
		String testValue = "";
		
		//get the checkBox name for the skill we're testing
		String skillCheckbox = inputSkill + "Checkbox";
		
		//A WebElement to keep track of the proficiency checkbox linked to the skill. Not necessary but it cleans up the code
		WebElement profCheckBox = driver.findElement(By.id(skillCheckbox));
		
		//Uncheck the profCheckBox if it is checked
		if(profCheckBox.isSelected())
			profCheckBox.click();
		
		//get the value of the skill we're testing for
		testValue = driver.findElement(By.id(inputSkill)).getAttribute("value");
		
		//See how well we did
		if(testValue.equals(expectedValue))
			return "pass";
		else
			return "fail";
	}
	
	public String testOneSkillWithProficiency(String inputSkill, String inputValue, String expectedValue) {
		//Get the input proficiency.
		String inputProficiency = getInputProficiency();
		
		//hardcode the proficiency bonus into the expected value
		expectedValue = add2Strings(expectedValue, inputProficiency);
		
		//This test value is what we hope is = to the expected value
		String testValue = "";
		
		//get the checkBox name for the skill we're testing
		String skillCheckbox = inputSkill + "Checkbox";
		
		//A WebElement to keep track of the proficiency checkbox linked to the skill. Not necessary but it cleans up the code
		WebElement profCheckBox = driver.findElement(By.id(skillCheckbox));
		
		//Check the profCheckBox if it is unchecked
		if(!profCheckBox.isSelected())
			profCheckBox.click();
		
		//get the value of the skill we're testing for
		testValue = driver.findElement(By.id(inputSkill)).getAttribute("value");
		
		//See how well we did
		if(testValue.equals(expectedValue))
			return "pass";
		else
			return "fail";
	}
	
	public String testOneSkillProficiencyChange(String inputSkill, String inputValue, String expectedValue) {
		
		//first run the proficiency test and make sure it works
		if(testOneSkillWithProficiency(inputSkill, inputValue, expectedValue) == "pass") {
			
			//get the current proficiency modifier and add 1. Then set the proficiency to this new number
				//get current proficiency modifier
				String inputProficiency = getInputProficiency();
				
				//add 1 to the proficiency
				changeProficiency(inputProficiency, "1");
			
			//now that we've added 1 to the proficiency
			if(testOneSkillWithProficiency(inputSkill, inputValue, expectedValue) == "pass") {
				//This is just a little clean-up bit where we set the proficiency mod back to what it was before
				//changeProficiency decrements with 0 instead of -1
				changeProficiency(inputProficiency, "0");
				return "pass";
			}else {
				//This is just a little clean-up bit where we set the proficiency mod back to what it was before
				//changeProficiency decrements with 0 instead of -1
				changeProficiency(inputProficiency, "0");
				return "fail";
			}
		}else {
			return "fail";
		}
	}
	
	public void testDriverTestOneSkillType(String inputStat, String inputValue, String expectedValue) {
		//Clear any field that we're going put inputs in
		driver.findElement(By.id(inputStat)).clear();
		
		//input the value we're using to test
		driver.findElement(By.id(inputStat)).sendKeys(inputValue);
		
		//Create a List that contains all skills that are associated with a particular stat
			//Get the class name we need, such as "strSkill"
			String skillType = inputStat.substring(0,3) + "Skill";
			
			//Push all skills of the same class into a list
			List<WebElement> skillsList = driver.findElements(By.className(skillType));
			
			//create a second list of strings
			List<String> skills = new ArrayList<>();
			
			//take all of the elements in the "skillsList" and push their id's into "skills"
			//"skills" is now a string list of all skills that share the same stat modifier (i.e. acrobatics, sneak, and slight of hand are all dex skills)
			for(int i = 0; i < skillsList.size(); i++)
		        skills.add(skillsList.get(i).getAttribute("id"));
			
		
		//for each skill in our skills list, we want to test to see if the modifiers and proficiency works right
		for(int i = 0; i < skills.size(); i++) {
			//test skills without proficiency
			String result = testOneSkillWithoutProficiency(skills.get(i), inputValue, expectedValue);
			//Some pretty looking error checking
			printTestOutput("Skills w/o proficiency", result, skills.get(i), inputValue, expectedValue);
			
			//test skills with proficiency
			result = testOneSkillWithProficiency(skills.get(i), inputValue, expectedValue);
			//Some pretty looking error checking
			printTestOutput("Skills w/ proficiency", result, skills.get(i), inputValue, expectedValue);
			
			//test skills when proficiency changes
			result = testOneSkillProficiencyChange(skills.get(i), inputValue, expectedValue);
				//Some pretty looking error checking
				printTestOutput("Skills test on prof change", result, skills.get(i), inputValue, expectedValue);
		}
	}
	
	
	/* 
	 * NOTE: This function is a DRIVER, which means all it does is call a bunch of functions. Each function within can be called independently!
	 * 
	 * inputValue is the value we're setting the stat mods to, expectedValue is the modifier we're expecting to see given the inputStat
	 * This test cycles through all stats and checks all relevant skills, saves, ect. to ensure everything recieved the modifier
	 */
	public void testDriverStatsAndModifiers(String[] inputValues, String[] expectedValues) {
		try {
			//We'll use this later to determine passes and fails
			String result;
			
			//This string contains the values for all the stats we want to check
			String[] inputStats = {"strength", "dexterity", "constitution", "intelligence", "wisdom", "charisma"};
			
			//Check and make sure that there's and expected value for every input
			if(inputValues.length != expectedValues.length) {
				System.out.println("Cannot Run Test! Inputs and Outputs of unequal length!");
				return;
			}
			
			//Here we loop through all the stats, performing tests on them
			for(int i = 0; i < inputStats.length; i++) {
				
				//Here we loop through all the input values we want to test for each stat
				for(int j = 0; j < inputValues.length; j++) {
					//Modifier Test
						//The actual test
						result = testOneStatMod(inputStats[i], inputValues[j], expectedValues[j]);
						
						//Some pretty looking error checking
						printTestOutput("Modifier test", result, inputStats[i], inputValues[j], expectedValues[j]);
						
					//Saving Throw Test
						//The actual test
						testDriverTestOneSavingThrow(inputStats[i], inputValues[j], expectedValues[j]);
						
					//Skills Test
						testDriverTestOneSkillType(inputStats[i], inputValues[j], expectedValues[j]);
				}
			}
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public String saveTestOneStat(String inputStat, String inputValue) {
		try {
			//A variable we'll need later to check loaded value vs input value
			String loadedTestValue;
			
			//Clear any field that we're going put inputs in
			driver.findElement(By.id(inputStat)).clear();
			
			//input the value we're using to test
			driver.findElement(By.id(inputStat)).sendKeys(inputValue);
			
			//check if data was saved
			saveAndReload();
			
			//get the value of the skill we're testing for
			loadedTestValue = driver.findElement(By.id(inputStat)).getAttribute("value");
			
			//Test if we loaded the same value we put in
			if(inputValue.equals(loadedTestValue))
				return "pass";
			else
				return "fail";
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
			return "fail";
		}
	}
	
	public void testDriverTestStatsSaveAndLoad(String[] inputValues) {
		//We'll use this to recieve pass/fail from the tests
		String result;
		
		//This string contains the values for all the stats we want to check
		String[] inputStats = {"strength", "dexterity", "constitution", "intelligence", "wisdom", "charisma"};
		
		//Here we loop through all the stats, performing tests on them
		for(int i = 0; i < inputStats.length; i++) {
			
			//Here we loop through all the input values we want to test for each stat
			for(int j = 0; j < inputValues.length; j++) {
				
				//Test saving/loading our stats
				result = saveTestOneStat(inputStats[i], inputValues[j]);
				//print some pretty error logging
				printTestOutput("Stat save/load test", result, inputStats[i], inputValues[j], inputValues[j]);
			}
		}
		
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// END OF CHARACTER SHEET TESTS
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	public static void main(String[] args) {
		STAT_MODS_SELENIUM myObj = new STAT_MODS_SELENIUM();
		
		//First, set up the browser and go to dndsip.ga
		myObj.invokeBrowser();
		
		//Login to test account
		myObj.driveByLoginToPlayerCharacters();
		
		//Go to test page
		myObj.driveByPlayerCharactersToCharacterSheet();
		
		//start testing
		String[] inputValues = {"19", "abc", "2.5", "-2"}; //{"18", "7", "abc", "2.5", "-2", "11"};
		String[] expectedValues = {"4", "-", "-4", "-6"}; //{"4", "-2", "-", "-4", "-6", "0"};
		myObj.testDriverStatsAndModifiers(inputValues, expectedValues);
		myObj.testDriverTestStatsSaveAndLoad(inputValues);
	}
}