package ga.dndsip.selenium.diceRoller;

import java.util.concurrent.TimeUnit;

import org.openqa.selenium.By;
import org.openqa.selenium.Keys;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.chrome.ChromeDriver;


public class diceRollerTest {
	
	WebDriver driver;
	
	//used to open the testing browser and go to our site
	public void invokeBrowser () {
		try {
			//change the second argument in this line to where your chromedriver is to run the code or it will give an error
			System.setProperty("webdriver.chrome.driver", "C:\\Users\\Allan\\Desktop\\selinium\\chromedriver\\chromedriver.exe");
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
	
	//goes to a page with the dice roller and opens it
	public void navigateToDMToolsAndOpenDiceRoller() {
		try {
			driver.findElement(By.name("username")).sendKeys("Jensen");
			driver.findElement(By.name("password")).sendKeys("password");
			driver.findElement(By.id("submit")).click();
			driver.findElement(By.xpath("//a[contains(text(), 'DM Tools')]")).click();
			driver.findElement(By.id("dicelogo")).click();
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	/* used to test the dice roller functionality
	 * takes in parallel arrays of diceAmount diceType mod
	 * checks if the result is between the max and min possible rolls
	 */
	public void testDiceRoller(String[] diceAmount, String[] diceType, String[] mod) {
		for (int i = 0; i < diceAmount.length; i++) {
			//the next 4 lines fills in the diceroller and clicks roll
			driver.findElement(By.id("numdice")).sendKeys(Keys.chord(Keys.CONTROL, "a"), diceAmount[i]);
			driver.findElement(By.id("typedice")).sendKeys(Keys.chord(Keys.CONTROL, "a"), diceType[i]);
			driver.findElement(By.id("modval")).sendKeys(Keys.chord(Keys.CONTROL, "a"), mod[i]);
			driver.findElement(By.id("rollSubmit")).click();
			//checks result to see if its between the max and min
			int result = Integer.parseInt(driver.findElement(By.id("rollResult")).getAttribute("value"));
			System.out.println("Dice Type: " + diceType[i] + "   Dice Amount: " + diceAmount[i] + "   Mod: " + mod[i]);
			System.out.println("Highest Possible Roll: " + ((Integer.parseInt(diceType[i]) * Integer.parseInt(diceAmount[i])) + Integer.parseInt(mod[i])) +
							"   Lowest Possible Roll: " + (Integer.parseInt(mod[i])) + 
							"   Result: " + result);
			boolean testResultBoolean= ((result < ((Integer.parseInt(diceType[i]) * Integer.parseInt(diceAmount[i])) + Integer.parseInt(mod[i]))) && (result > Integer.parseInt(mod[i])));
			String testResult = "fail";
			if (testResultBoolean) {
				testResult = "pass";
			}
			System.out.println("Dice Roll Test " + (i+1) + ": " + testResult + "\n");
		}
	}
	
	public static void main(String[] args) {
		diceRollerTest testObj = new diceRollerTest();
		//parallel arrays make sure that they are all the same length
		String[] diceAmount = {"1", "1", "2", "3", "4"};
		String[] diceType =   {"20", "6", "4", "8", "4"};
		String[] mod =        {"0" , "2", "1", "-1", "-4"};
		
		testObj.invokeBrowser();
		testObj.navigateToDMToolsAndOpenDiceRoller();
		testObj.testDiceRoller(diceAmount, diceType, mod);
	}
}
