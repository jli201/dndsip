package dndtesting;

import java.util.concurrent.TimeUnit;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.chrome.ChromeDriver;

public class loginTest {
	
	WebDriver driver;
	
	boolean retVal;
	String errorTxt = "Invalid username or password.";

	
	//starts the Google Chrome Browser
	public void invokeBrowser() {
		try {
			System.setProperty("webdriver.chrome.driver" , "//Users//jensen//Selenium//Selenium//chromedriver");
			driver = new ChromeDriver();
			driver.manage().deleteAllCookies();
			driver.manage().window().maximize();
			driver.manage().timeouts().implicitlyWait(30, TimeUnit.SECONDS);
			driver.manage().timeouts().pageLoadTimeout(30, TimeUnit.SECONDS);
			driver.get("https://dndsip.ga/");
		
		} catch (Exception e) {
			e.printStackTrace();
			
		}
	}
	//The login test function
	public void tryLogin() {
		
		//inserts wrong password, right username
		driver.findElement(By.name("username")).sendKeys("jensen");
		driver.findElement(By.name("password")).sendKeys("123456");
		driver.findElement(By.id("submit")).click();
		String loginTxt = driver.findElement(By.id("errorText")).getText();
		retVal = errorTxt.equals( loginTxt );
		if (retVal == true ) {
			System.out.println("Invalid Password 1 Test: PASS");
		}
		else {
			System.out.println("Invalid Password 1 Test: FAIL");
		}
		
		
		//inserts wrong password, right username
		driver.findElement(By.name("username")).sendKeys("jensen");
		driver.findElement(By.name("password")).sendKeys("123");
		driver.findElement(By.id("submit")).click();
		loginTxt = driver.findElement(By.id("errorText")).getText();
		retVal = errorTxt.equals( loginTxt );
		if (retVal == true ) {
			System.out.println("Invalid Password 2 Test: PASS");
		}
		else {
			System.out.println("Invalid Password 2 Test: FAIL");
		}
		
		
		//inserts wrong password, right username
		driver.findElement(By.name("username")).sendKeys("jensen");
		driver.findElement(By.name("password")).sendKeys("abcdefg");
		driver.findElement(By.id("submit")).click();
		loginTxt = driver.findElement(By.id("errorText")).getText();
		retVal = errorTxt.equals( loginTxt );
		if (retVal == true ) {
			System.out.println("Invalid Password 3 Test: PASS");
		}
		else {
			System.out.println("Invalid Password 3 Test: FAIL");
		}
		
		
		
		
		
		//inserts right password, wrong username
		driver.findElement(By.name("username")).sendKeys("jensenn");
		driver.findElement(By.name("password")).sendKeys("password");
		driver.findElement(By.id("submit")).click();
		loginTxt = driver.findElement(By.id("errorText")).getText();
		retVal = errorTxt.equals( loginTxt );
		if (retVal == true ) {
			System.out.println("Invalid Username 1 Test: PASS");
		}
		else {
			System.out.println("Invalid Username 1 Test: FAIL");
		}
		//inserts right password, wrong username
		driver.findElement(By.name("username")).sendKeys("j");
		driver.findElement(By.name("password")).sendKeys("password");
		driver.findElement(By.id("submit")).click();
		loginTxt = driver.findElement(By.id("errorText")).getText();
		retVal = errorTxt.equals( loginTxt );
		if (retVal == true ) {
			System.out.println("Invalid Username 2 Test: PASS");
		}
		else {
			System.out.println("Invalid Username 2 Test: FAIL");
		}
		//right password, wrong username
		driver.findElement(By.name("username")).sendKeys("j12n345");
		driver.findElement(By.name("password")).sendKeys("password");
		driver.findElement(By.id("submit")).click();
		loginTxt = driver.findElement(By.id("errorText")).getText();
		retVal = errorTxt.equals( loginTxt );
		if (retVal == true ) {
			System.out.println("Invalid Username 3 Test: PASS");
		}
		else {
			System.out.println("Invalid Username 3 Test: FAIL");
		}
		
		
		
		
		//try successful login
		driver.findElement(By.name("username")).sendKeys("jensen");
		driver.findElement(By.name("password")).sendKeys("password");
		driver.findElement(By.id("submit")).click();
		
		
		String expectedURL = "https://dndsip.ga/character_list.php";
		String actualURL = driver.getCurrentUrl();
		
		retVal = expectedURL.equals(actualURL);
		if (retVal == true) {
			System.out.println("Successful Login Test: PASS");
			
		}
		else {
			System.out.println("Successful Login Test: FAIL");
		}

	

	}
	

	
	//creates new object of loginTest and calls the two functions
	public static void main(String[] args) {
		loginTest myObj = new loginTest();
		myObj.invokeBrowser();
		myObj.tryLogin();
	}

}
