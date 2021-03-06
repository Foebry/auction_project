import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

const articleAPI = createApi({
    reducerPath: "articleState",
    baseQuery: fetchBaseQuery({
        baseUrl: import.meta.env.VITE_API,
        credentials: "include",
    }),
    endpoints: (builder) => ({
        getArticles: builder.query({
            query: ({ page, page_count }) => {
                const query = page || page_count ? "/articles?" : "/articles";
                let params = [];

                if (page) params = [...params, `page=${page}`];
                if (page_count)
                    params = [...params, `page_count=${page_count}`];

                params = params.join("&");

                return `${query}${params}`;
            },
            providesTags: ["allArticles"],
        }),
        getArticleById: builder.query({
            query: (id) => `/article/${id}`,
        }),
        postArticle: builder.mutation({
            query: ({ art_id, art_name, art_img, art_cat_id }) => ({
                url: `/articles`,
                method: "POST",
                body: {
                    art_id,
                    art_name,
                    art_img,
                    art_cat_id,
                    csrf: localStorage.getItem("csrf"),
                },
            }),
            invalidatesTags: ["allArticles"],
        }),
        patchArticleById: builder.mutation({
            query: ({ art_id, art_name, art_img, art_cat_id }) => ({
                url: `/article/${art_id}`,
                method: "PATCH",
                body: {
                    art_name,
                    art_img: art_img ?? "",
                    art_cat_id,
                    csrf: localStorage.getItem("csrf"),
                },
            }),
            invalidatesTags: ["allArticles"],
        }),
        deleteArticle: builder.mutation({
            query: (id) => ({
                url: `/article/${id}`,
                method: "DELETE",
                body: {
                    csrf: localStorage.getItem("csrf"),
                },
            }),
            invalidatesTags: ["allArticles"],
        }),
        uploadImage: builder.mutation({
            query: (formData) => ({
                url: "/upload",
                method: "POST",
                body: formData,
            }),
        }),
    }),
});

export default articleAPI;
export const {
    useGetArticlesQuery,
    useGetArticleByIdQuery,
    usePostArticleMutation,
    usePatchArticleByIdMutation,
    useDeleteArticleMutation,
    useUploadImageMutation,
} = articleAPI;
