import json
import sys
import history

from history.base.knowledge_db import KnowledgeDatabase
from history.tasks.tasks_dates import TasksDate

path = "./history/history/data"
database = KnowledgeDatabase(path)

from flask import Flask, jsonify, request
app = Flask(__name__)


@app.route('/get_random_task')
def get_random_task():
    task_type = request.args.get('task_type')

    task_id = database.get_random_task_id(task_type)
    task = database.get_task(task_id, task_type)

    output = {
        "task": {
            "id": int(task_id),  # TOOD: numpy.int64 by default
            "type": task_type,
            "question": task.question
        },
        "status": 200,
    }

    return jsonify(output)


@app.route('/score_task')
def score_task():
    with open("./input.json", "r") as infile:
        query = json.load(infile)

    task_id = query["task_id"]
    task_type = query["task_type"]
    answer = query["answer"]

    task = database.get_task(task_id, task_type)
    score = task.score(answer)

    output = {
        "answer": {
            "score": str(score).lower(),
        },
        "status": 200,
    }

    return jsonify(output)

if __name__ == '__main__':
    app.run()


"""
with open(sys.argv[1], "r") as infile:
    query = json.load(infile)

endpoint = query["endpoint"]


if endpoint == "get_random_task":
    task_type = query["task_type"]
    task_id = database.get_random_task_id(task_type)
    task = database.get_task(task_id, task_type)

    output = {
        "task": {
            "id": int(task_id),  # TOOD: numpy.int64 by default
            "type": task_type,
            "question": task.question
        },
        "status": 200,
    }

elif endpoint == "score_task":
    task_id = query["task_id"]
    task_type = query["task_type"]
    answer = query["answer"]

    task = database.get_task(task_id, task_type)
    score = task.score(answer)

    output = {
        "answer": {
            "score": score,
        },
        "status": 200,
    }

else:
    output = {
        "status": 300,
        "message": "some error",
    }


print(json.dumps(output))
"""
