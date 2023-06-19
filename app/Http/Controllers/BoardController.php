<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;

class BoardController extends Controller
{
    /**
     * @brief 게시물 목록
     * @author 추광선
     * @param int $page 페이지
     * @param int $per_page 페이지당 글수
     * @return json
     */
    public function index(Request $request)
    {
        $return = [];

        $return = Board::OrderBy('created_at', 'desc')->paginate($request->per_page);

        return response($return);
    }

    /**
     * @brief 게시물 등록
     * @author 추광선
     * @param int $user_id 회원아아디
     * @param string $write 작성자이름
     * @param string $subject 글제목
     * @param string $content 글내용
     * @return json(고유id)
     */
    public function store(Request $request)
    {
        $return = [];

        $board = new Board;
        $board->user_id = $request->user_id;
        $board->writer = $request->writer;
        $board->subject = $request->subject;
        $board->content = $request->content;
        if ($board->save()) {
            $return['id'] = $board->id;
        }

        return response($return);
    }

    /**
     * @brief 게시물 정보
     * @author 추광선
     * @param int $id 고유ID
     * @return json
     */
    public function show(string $id)
    {
        $return = Board::find($id);

        if (empty($return)) {
            return response($return, 404);
        }

        return response($return);
    }

    /**
     * @brief 게시물 수정
     * @author 추광선
     * @param int $id 고유ID
     * @param string $write 작성자이름
     * @param string $subject 글제목
     * @param string $content 글내용
     * @return json
     */
    public function update(Request $request, string $id)
    {
        $return = [];

        $board = Board::find($id);

        if (!$board) {
            return response($return, 404);
        }

        $board->writer = $request->writer;
        $board->subject = $request->subject;
        $board->content = $request->content;
        if ($board->save()) {
            $return['id'] = $id;
        }

        return response($return);
    }

    /**
     * @brief 게시물 삭제
     * @author 추광선
     * @param int $id 고유ID
     * @return json
     */
    public function destroy(string $id)
    {
        $return = [];

        $board = Board::find($id);

        if (!$board) {
            return response($return, 404);
        }

        if ($board->delete()) {
            $return['id'] = $id;
        }

        return response($return);
    }
}
