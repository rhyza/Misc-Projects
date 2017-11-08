from collections import deque


class UndirectedGraph:
    def __init__(self):
        """Graph is an adjacency list."""
        self._graph = dict()

    def addVertex(self, vertex):
        """Creates a new vertex. If vertex already exists,
        then it is left alone.
        """
        if not self.exists(vertex):
            self._graph[vertex] = []

    def addEdge(self, vertex1, vertex2):
        """Creates a new edge. If either vertex does not exist,
        then it is created.
        """
        try:
            self._graph[vertex1].append(vertex2)
        except KeyError:
            self._graph[vertex1] = [vertex2]
        try:
            self._graph[vertex2].append(vertex1)
        except KeyError:
            self._graph[vertex2] = [vertex1]

    def delVertex(self, vertex):
        """Deletes a vertex and all its edges."""
        for edge in self._graph[vertex]:
            self._graph[edge].remove(vertex)
        del self._graph[vertex]

    def delEdge(self, vertex1, vertex2):
        """Deletes an edge if it exists."""
        if self.exists(vertex1) and self.exists(vertex2):
            try:
                self._graph[vertex1].remove(vertex2)
                self._graph[vertex2].remove(vertex1)
            except ValueError:
                pass

    def getEdges(self, vertex):
        """Returns list of vertices connected to given vertex.
        Returns none if vertex is not in the graph.
        """
        try:
            return self._graph[vertex]
        except KeyError:
            return None

    def dfs(self, start, end):
        """Returns true if a path exists from start to end."""
        if self.exists(start) and self.exists(end):
            stack = [start]
            visited = []
            while stack:
                vertex = stack.pop()
                visited.append(vertex)
                if vertex == end:
                    return True
                for edge in self.getEdges(vertex)[::-1]:
                    if edge not in visited:
                        stack.append(edge)
        return False

    def bfs(self, start, end):
        """Returns true if a path exists from start to end."""
        if self.exists(start) and self.exists(end):
            queue = deque([start])
            visited = []
            while queue:
                vertex = queue.popleft()
                visited.append(vertex)
                if vertex == end:
                    return True
                for edge in self.getEdges(vertex):
                    if edge not in visited:
                        queue.append(edge)
        return False

    def exists(self, vertex):
        return vertex in self._graph
