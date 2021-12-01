#!/bin/bash

genMenaces ()
{
   for ((i = 0; i < 26; i++)); do
      echo "la variable que tu m'a donné est ::$1"
   done
}

genMenaces $1
