#!/bin/bash
export FLASK_APP=./cashman/index.py
source $(pipenv --venv)\\Scripts\\activate
flask run -h 0.0.0.0