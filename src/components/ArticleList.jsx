import React, { useEffect, useMemo, useState } from "react";
import { MdDelete, MdModeEdit } from "react-icons/md";
import {
    useDeleteArticleMutation,
    useGetArticlesQuery,
} from "../data/articleAPI";
import { useGetCategoryByIdQuery } from "../data/categoryAPI";

const ArticleList = () => {
    const [nameFilter, setNameFilter] = useState("");

    const { data, isError, isLoading } = useGetArticlesQuery(undefined, {
        pollingInterval: 0,
        refetchOnFocus: true,
        refetchOnReconnect: true,
    });

    const memoData = useMemo(() => {
        console.log(data);
        return data
            ?.filter((el) =>
                el.art_name.toLowerCase().includes(nameFilter.toLowerCase())
            )
            .map(({ art_id, art_name, art_cat_id }) => {
                const {
                    data: categoryData,
                    isError: categoryError,
                    isLoading: categoryLoading,
                } = useGetCategoryByIdQuery(art_cat_id);
                console.log(categoryData);
                return (
                    <li className="list__article" key={art_id}>
                        <p>{art_name}</p>
                        <div className="list__buttons">
                            <button className="list__buttons__button">
                                <MdModeEdit />
                            </button>
                            <button
                                className="list__buttons__button"
                                onClick={() => deleteUser(id)}
                            >
                                <MdDelete className="icon" />
                            </button>
                        </div>
                    </li>
                );
            });
    }, [data, nameFilter]);

    const [deleteArticle] = useDeleteArticleMutation();

    return (
        <ul className="list">
            <li className="list__article">
                <p>Naam</p>
                <p>Categorie</p>
                <input
                    type="text"
                    placeholder="Article Name"
                    value={nameFilter}
                    className="listFilter"
                    onChange={(e) => setNameFilter(e.target.value)}
                />
            </li>
            {isError && <p>error..</p>}
            {isLoading && <p>loading..</p>}
            {memoData}
        </ul>
    );
};

export default ArticleList;
