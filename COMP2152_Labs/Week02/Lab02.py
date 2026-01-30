#Solution for the week 2 lab exercise

import random


choices = ["rock", "paper", "scissors"]

playerChoice = input("Enter a number between 1 to 3 for the following choices: 1-rock, 2-paper, 3-scissors: ")


playerChoice = int(playerChoice)

if playerChoice <1 or playerChoice >3:
    print("Invalid choice! Please select a number between 1 and 3.")
else:
    # devlop the game logic using if/elif/else statements
    computerChoice = random.randint(1,3)

    if playerChoice == computerChoice:
        print("It's a tie!")
    elif playerChoice == 1 and computerChoice == 3:
        print ("Rock beats scissors. You win!")
    elif playerChoice == 2 and computerChoice == 1:
        print ("paper beats rock. You win!")
    elif playerChoice == 3 and computerChoice == 2:
        print ("scissors beats paper. You win!")
    else:
        print("You lose!")