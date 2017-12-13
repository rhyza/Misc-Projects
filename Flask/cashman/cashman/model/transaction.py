import datetime as dt
from mashmallow import Schema, fields


class Transaction(object):
    def __init__(self, description, amount, type):
        self.description = description
        self.amount = amount
        self.created_at = dt.datetime.now()
        self.type = type

    def __repr__(self):
        return '<Transaction(name={self.description!r})>'.format(self=self)


class TransactionSchema(Schema):
    """Used to deserialize and serialize instances of Transaction
       from and to JSON objects.
    """
    description = fields.Str()
    amount = fields.Number()
    created_at = fields.Date()
    type = fields.Str()
