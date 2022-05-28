import React, { useContext, useMemo, useState } from "react";
import { MdDelete, MdModeEdit, MdAdd } from "react-icons/md";
import { AppContext } from "../../context/AppContext";
import {
    useDeleteArticleMutation,
    useGetArticlesQuery,
} from "../../data/articleAPI";
import { useGetCategoriesQuery } from "../../data/categoryAPI";

const Articles = () => {
    const [nameFilter, setNameFilter] = useState("");

    const { data, isError, isLoading } = useGetArticlesQuery(undefined, {
        pollingInterval: 0,
        refetchOnFocus: true,
        refetchOnReconnect: true,
    });
    const {
        data: categoryData,
        isError: categoryError,
        isLoading: categoryLoading,
    } = useGetCategoriesQuery(undefined);

    const memoData = useMemo(() => {
        return data
            ?.filter((el) =>
                el.art_name.toLowerCase().includes(nameFilter.toLowerCase())
            )
            .map(({ art_id, art_name, art_cat_id }) => {
                return (
                    <li className="list__article" key={art_id}>
                        <p>{art_name}</p>
                        <p>
                            {
                                categoryData?.filter(
                                    (el) => el.cat_id === art_cat_id
                                )[0].cat_name
                            }
                        </p>
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
    }, [data, nameFilter, categoryData]);

    return (
        <section className="content" style={{ margin: "0 auto" }}>
            <div className="content__create">
                <button>
                    <div>
                        <MdAdd className="icon" />
                        <span>Toevoegen</span>
                    </div>
                </button>
            </div>
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
        </section>
    );
};

export default Articles;
