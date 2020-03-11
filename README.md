#### About 
This is my typical project structure for Symfony 4. It works for projects of any size. Time-honoured.

#### Project structure (additions to the standard)
 - /DataFixtures/SQL/ ```The test data dump```
 - /Exception ```Custom exceptions```  
 - /Model ```Business models which are not represented by data in DB```
 - /Service ```Samples from two or more repositories or specific work with DB. For dependency injection only. ```
 - /Utils ```Classes that do not depend on data or business logic (parsers, utilities, etc.)```
 - /test/Functional ```all tests of Controllers ```
 - /test/Integration ```all tests of Repository/Service```  
 - /test/Unit ```all test of Model/Utils```  
      
There are code examples!